<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use PDO;
use PDOException;

require_once dirname(__DIR__, 2) . '/includes/formularios.php';   // capturar(), sanitizar_texto(), largo()

/**
 * CONTROLADOR de productos: recibe la solicitud, valida, le pide los datos al
 * MODELO y elige la VISTA. No tiene SQL ni HTML.
 *
 *   index()     listado            (GET)
 *   crear()     alta               (GET muestra el formulario, POST guarda)
 *   editar()    modificación       (GET muestra, POST guarda)
 *   eliminar()  baja               (solo POST)
 */
class ProductoController extends Controller
{
    private ProductoModel $productos;
    private CategoriaModel $categorias;

    public function __construct(PDO $pdo)
    {
        $this->productos  = new ProductoModel($pdo);
        $this->categorias = new CategoriaModel($pdo);
    }

    // ------------------------------------------------------------------ READ
    public function index(): void
    {
        // Mensajes que llegan por la URL (?status=...). Solo se aceptan estos valores.
        $mensajes = [
            'created'    => ['ok',    'Producto creado correctamente.'],
            'updated'    => ['ok',    'Producto actualizado correctamente.'],
            'deleted'    => ['ok',    'Producto eliminado correctamente.'],
            'notfound'   => ['error', 'El producto solicitado no existe.'],
            'inuse'      => ['error', 'No se puede eliminar: el producto figura en pedidos. Desactivalo desde "Editar".'],
            'badrequest' => ['error', 'Solicitud inválida.'],
        ];
        $status  = $_GET['status'] ?? '';
        $mensaje = (is_string($status) && isset($mensajes[$status])) ? $mensajes[$status] : null;

        $this->render('productos/listado', [
            'titulo_pagina'      => 'Administración de productos',
            'descripcion_pagina' => 'Gestión de productos de la boutique.',
            'registros'          => $this->productos->todosConCategoria(),
            'mensaje'            => $mensaje,
        ]);
    }

    // ---------------------------------------------------------------- CREATE
    public function crear(): void
    {
        $errores = [];
        $datos   = ['nombre' => '', 'categoria_id' => '', 'descripcion' => '', 'precio' => '', 'stock' => '0', 'imagen' => '', 'activo' => 1];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$datos, $errores] = $this->validar();

            if (empty($errores)) {
                try {
                    $this->productos->crear($datos);
                    $this->redirigir('index.php?status=created');
                } catch (PDOException $ex) {
                    error_log('ProductoController::crear: ' . $ex->getMessage());
                    $errores['general'] = 'No se pudo guardar el producto. Intentá nuevamente.';
                }
            }
        }

        $this->render('productos/crear', [
            'titulo_pagina' => 'Nuevo producto',
            'datos'         => $datos,
            'errores'       => $errores,
            'categorias'    => $this->categorias->todas(),
            'accion'        => 'crear.php',
            'texto_boton'   => 'Guardar producto',
        ]);
    }

    // ---------------------------------------------------------------- UPDATE
    public function editar(): void
    {
        // El id siempre viaja en la URL (editar.php?id=3), al abrir y al guardar.
        $id = $this->idValido($_GET['id'] ?? null);
        if ($id === null) {
            $this->redirigir('index.php?status=badrequest');
        }

        $producto = $this->productos->buscarPorId($id);
        if ($producto === null) {
            $this->redirigir('index.php?status=notfound');
        }

        $errores = [];
        $datos   = [
            'nombre'       => (string) $producto['nombre'],
            'categoria_id' => (string) $producto['categoria_id'],
            'descripcion'  => (string) $producto['descripcion'],
            'precio'       => (string) $producto['precio'],
            'stock'        => (string) $producto['stock'],
            'imagen'       => (string) $producto['imagen'],
            'activo'       => (int) $producto['activo'],
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$datos, $errores] = $this->validar();

            if (empty($errores)) {
                try {
                    $this->productos->actualizar($id, $datos);
                    $this->redirigir('index.php?status=updated');
                } catch (PDOException $ex) {
                    error_log('ProductoController::editar: ' . $ex->getMessage());
                    $errores['general'] = 'No se pudo actualizar el producto. Intentá nuevamente.';
                }
            }
        }

        $this->render('productos/editar', [
            'titulo_pagina' => 'Editar producto',
            'id'            => $id,
            'datos'         => $datos,
            'errores'       => $errores,
            'categorias'    => $this->categorias->todas(),
            'accion'        => 'editar.php?id=' . $id,
            'texto_boton'   => 'Guardar cambios',
        ]);
    }

    // ---------------------------------------------------------------- DELETE
    public function eliminar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {         // borrar solo por POST
            $this->redirigir('index.php?status=badrequest');
        }

        $id = $this->idValido($_POST['id'] ?? null);
        if ($id === null) {
            $this->redirigir('index.php?status=badrequest');
        }

        try {
            $estado = $this->productos->eliminar($id) ? 'deleted' : 'notfound';
        } catch (PDOException $ex) {
            // 23000 = violación de clave foránea (el producto está en detalle_pedidos)
            $estado = ($ex->getCode() === '23000') ? 'inuse' : 'badrequest';
            error_log('ProductoController::eliminar: ' . $ex->getMessage());
        }

        $this->redirigir('index.php?status=' . $estado);
    }

    // ------------------------------------------------------------ utilidades
    /** Devuelve el id como entero positivo o null si no es válido. */
    private function idValido(mixed $valor): ?int
    {
        $id = filter_var($valor, FILTER_VALIDATE_INT);
        return ($id === false || $id === null || $id < 1) ? null : $id;
    }

    /**
     * Captura, sanitiza y valida el formulario.
     * @return array{0: array, 1: array} [$datos, $errores]
     */
    private function validar(): array
    {
        $errores = [];

        // 1) Captura + sanitización (trim + quitar etiquetas HTML)
        $datos = [
            'nombre'       => sanitizar_texto(capturar('POST', 'nombre')),
            'categoria_id' => capturar('POST', 'categoria_id'),
            'descripcion'  => sanitizar_texto(capturar('POST', 'descripcion')),
            'precio'       => str_replace(',', '.', capturar('POST', 'precio')),
            'stock'        => capturar('POST', 'stock'),
            'imagen'       => sanitizar_texto(capturar('POST', 'imagen')),
            'activo'       => isset($_POST['activo']) ? 1 : 0,
        ];

        // 2) Validación en el servidor
        if (empty($datos['nombre'])) {
            $errores['nombre'] = 'El nombre es obligatorio.';
        } elseif (largo($datos['nombre']) < 2 || largo($datos['nombre']) > 100) {
            $errores['nombre'] = 'El nombre debe tener entre 2 y 100 caracteres.';
        }

        // La categoría debe ser un entero Y existir (se lo pregunta al modelo)
        $cat = filter_var($datos['categoria_id'], FILTER_VALIDATE_INT);
        if ($cat === false) {
            $errores['categoria_id'] = 'Elegí una categoría.';
        } elseif (!$this->categorias->existe($cat)) {
            $errores['categoria_id'] = 'La categoría elegida no existe.';
        }

        $precio = filter_var($datos['precio'], FILTER_VALIDATE_FLOAT);
        if ($precio === false || $precio < 0 || $precio > 99999999) {
            $errores['precio'] = 'El precio debe ser un número mayor o igual a 0.';
        }

        $stock = filter_var($datos['stock'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100000]]);
        if ($stock === false) {
            $errores['stock'] = 'El stock debe ser un número entero mayor o igual a 0.';
        }

        if (largo($datos['descripcion']) > 500) {
            $errores['descripcion'] = 'La descripción no puede superar los 500 caracteres.';
        }

        if ($datos['imagen'] !== '' && !preg_match('/^[\w\-.]{1,200}$/', $datos['imagen'])) {
            $errores['imagen'] = 'El nombre de imagen solo puede tener letras, números, guiones y punto.';
        }

        return [$datos, $errores];
    }
}
