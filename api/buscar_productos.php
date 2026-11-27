<?php
/**
 * api/buscar_productos.php  -  ENDPOINT JSON (TP9)
 * --------------------------------------------------------------
 * Devuelve productos de la boutique en formato JSON. No genera HTML:
 * la vista la construye el cliente con JavaScript (fetch).
 *
 * Parámetros GET (todos opcionales):
 *   q          texto a buscar en nombre o descripción (máx. 60 caracteres)
 *   categoria  slug de la categoría: tratamiento | limpieza | nutricion
 *   id         devuelve un solo producto (404 si no existe)
 *
 * Códigos HTTP:
 *   200 OK · 400 Bad Request (parámetros inválidos) · 404 Not Found
 *   405 Method Not Allowed · 500 Internal Server Error
 */
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

define('RESPUESTA_JSON', true);                      // si falla la conexión, responder JSON y no HTML
require_once __DIR__ . '/../config/conexion.php';   // crea el objeto PDO en $pdo

/** Envía la respuesta JSON con el código de estado indicado y termina. */
function responder(int $codigo, array $cuerpo): void
{
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/** "Nutrición" -> "nutricion" (para comparar con el slug que manda el cliente). */
function slug(string $texto): string
{
    $texto = mb_strtolower(trim($texto), 'UTF-8');
    return strtr($texto, ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n']);
}

// 1) Solo se permite GET (es una operación de lectura: la R de CRUD)
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    responder(405, ['status' => 'error', 'message' => 'Método no permitido. Usá GET.']);
}

// 2) Capturar y validar parámetros (deben ser texto, no arreglos: ?q[]=x)
foreach (['q', 'categoria', 'id'] as $nombre) {
    if (isset($_GET[$nombre]) && !is_string($_GET[$nombre])) {
        responder(400, ['status' => 'error', 'message' => "El parámetro '$nombre' no es válido."]);
    }
}

$busqueda  = trim(strip_tags($_GET['q'] ?? ''));
$categoria = slug($_GET['categoria'] ?? '');
$idParam   = $_GET['id'] ?? null;

if (mb_strlen($busqueda, 'UTF-8') > 60) {
    responder(400, ['status' => 'error', 'message' => 'La búsqueda no puede superar los 60 caracteres.']);
}

$columnas = 'p.id, p.nombre, p.descripcion, p.precio, p.stock, p.imagen, c.nombre AS categoria';
$desde    = 'FROM productos p INNER JOIN categorias c ON c.id = p.categoria_id';

/** Convierte una fila de la BD en el formato que viaja por JSON. */
function formatear(array $f): array
{
    return [
        'id'          => (int) $f['id'],
        'nombre'      => $f['nombre'],
        'descripcion' => $f['descripcion'],
        'precio'      => (float) $f['precio'],
        'stock'       => (int) $f['stock'],
        'imagen'      => $f['imagen'],
        'categoria'   => $f['categoria'],
    ];
}

try {
    // 3a) Un solo producto: ?id=N
    if ($idParam !== null) {
        $id = filter_var($idParam, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            responder(400, ['status' => 'error', 'message' => 'El id debe ser un número entero positivo.']);
        }
        $stmt = $pdo->prepare("SELECT $columnas $desde WHERE p.id = :id AND p.activo = 1");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch();
        if (!$fila) {
            responder(404, ['status' => 'error', 'message' => 'Producto no encontrado.']);
        }
        responder(200, ['status' => 'success', 'data' => formatear($fila)]);
    }

    // 3b) Si se pidió una categoría, debe existir (si no, 404)
    $categoriaId = null;
    if ($categoria !== '' && $categoria !== 'todos') {
        foreach ($pdo->query('SELECT id, nombre FROM categorias') as $c) {
            if (slug($c['nombre']) === $categoria) { $categoriaId = (int) $c['id']; break; }
        }
        if ($categoriaId === null) {
            responder(404, ['status' => 'error', 'message' => 'La categoría no existe.']);
        }
    }

    // 3c) Listado con filtros opcionales (consulta preparada: sin SQL Injection)
    $condiciones = ['p.activo = 1'];
    $params      = [];

    if ($busqueda !== '') {
        // Se escapan % _ y ! para que el usuario no pueda usarlos como comodines
        $patron = '%' . strtr($busqueda, ['!' => '!!', '%' => '!%', '_' => '!_']) . '%';
        $condiciones[]  = "(p.nombre LIKE :q1 ESCAPE '!' OR p.descripcion LIKE :q2 ESCAPE '!')";
        $params[':q1']  = $patron;
        $params[':q2']  = $patron;
    }
    if ($categoriaId !== null) {
        $condiciones[]    = 'p.categoria_id = :cat';
        $params[':cat']   = $categoriaId;
    }

    $sql  = "SELECT $columnas $desde WHERE " . implode(' AND ', $condiciones) . ' ORDER BY p.nombre LIMIT 24';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $productos = array_map('formatear', $stmt->fetchAll());

    responder(200, [
        'status' => 'success',
        'total'  => count($productos),
        'data'   => $productos,
    ]);

} catch (PDOException $e) {
    error_log('api/buscar_productos.php: ' . $e->getMessage());   // el detalle queda en el log, no se muestra
    responder(500, ['status' => 'error', 'message' => 'Error al consultar la base de datos.']);
}
