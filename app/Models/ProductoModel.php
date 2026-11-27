<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

/**
 * MODELO de productos: ÚNICO lugar donde hay SQL de la tabla `productos`.
 * Todas las consultas son preparadas (:parametros) -> sin SQL Injection.
 * No sabe nada de HTML, de $_GET ni de $_POST.
 */
class ProductoModel
{
    public function __construct(private PDO $pdo) {}

    /** Listado con el nombre de la categoría (JOIN), del más nuevo al más viejo. */
    public function todosConCategoria(): array
    {
        return $this->pdo->query(
            'SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, p.activo, c.nombre AS categoria
             FROM productos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             ORDER BY p.id DESC'
        )->fetchAll();
    }

    /** Devuelve el producto o null si no existe. */
    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM productos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch();
        return $fila === false ? null : $fila;
    }

    /** @param array $d datos ya validados por el controlador */
    public function crear(array $d): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, imagen, activo)
             VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :imagen, :activo)'
        );
        $stmt->execute($this->parametros($d));
    }

    public function actualizar(int $id, array $d): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE productos
             SET categoria_id = :categoria_id, nombre = :nombre, descripcion = :descripcion,
                 precio = :precio, stock = :stock, imagen = :imagen, activo = :activo
             WHERE id = :id'
        );
        $stmt->execute($this->parametros($d) + [':id' => $id]);
    }

    /**
     * Elimina un producto. Devuelve true si existía y se borró, false si no existía.
     * @throws PDOException si el producto está en pedidos (clave foránea, código 23000)
     */
    public function eliminar(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM productos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    /** Arma el array de parámetros del INSERT/UPDATE a partir de los datos validados. */
    private function parametros(array $d): array
    {
        return [
            ':categoria_id' => (int) $d['categoria_id'],
            ':nombre'       => $d['nombre'],
            ':descripcion'  => $d['descripcion'],
            ':precio'       => (float) $d['precio'],
            ':stock'        => (int) $d['stock'],
            ':imagen'       => $d['imagen'] !== '' ? $d['imagen'] : null,
            ':activo'       => (int) $d['activo'],
        ];
    }
}
