<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * MODELO de productos (CodeIgniter 4).
 * Usa la base `kora_hair` y la tabla `productos` del TP6, a través del
 * Query Builder del framework (no se escribe SQL a mano).
 */
class ProductoModel extends Model
{
    protected $table         = 'productos';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;                 // created_at / updated_at los maneja MySQL
    protected $allowedFields = ['categoria_id', 'nombre', 'descripcion', 'precio', 'stock', 'imagen', 'activo'];

    /** Productos activos con el nombre de su categoría (JOIN), opcionalmente de una sola categoría. */
    public function activosConCategoria(?int $categoriaId = null): array
    {
        $this->select('productos.id, productos.nombre, productos.descripcion, productos.precio, productos.stock, productos.imagen, categorias.nombre AS categoria')
             ->join('categorias', 'categorias.id = productos.categoria_id')
             ->where('productos.activo', 1);

        if ($categoriaId !== null) {
            $this->where('productos.categoria_id', $categoriaId);
        }

        return $this->orderBy('productos.nombre', 'ASC')->findAll();
    }

    /** Un producto activo con su categoría, o null si no existe. */
    public function detalle(int $id): ?array
    {
        return $this->select('productos.id, productos.nombre, productos.descripcion, productos.precio, productos.stock, productos.imagen, categorias.nombre AS categoria')
                    ->join('categorias', 'categorias.id = productos.categoria_id')
                    ->where('productos.id', $id)
                    ->where('productos.activo', 1)
                    ->first();
    }

    /** Pequeño reporte: cantidad de productos, stock total y precio promedio. */
    public function resumen(): array
    {
        return $this->selectCount('id', 'total')
                    ->selectSum('stock', 'stock_total')
                    ->selectAvg('precio', 'precio_promedio')
                    ->where('activo', 1)
                    ->first() ?? ['total' => 0, 'stock_total' => 0, 'precio_promedio' => 0];
    }
}
