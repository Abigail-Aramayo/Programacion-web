<?php

namespace App\Controllers;

use App\Models\ProductoModel;

/**
 * API REST simple: devuelve JSON (sin vistas).
 *   GET /api/productos        -> lista de productos activos (acepta ?categoria=N)
 *   GET /api/productos/3      -> un producto (404 si no existe)
 */
class ApiProductos extends BaseController
{
    public function index()
    {
        $categoria   = $this->request->getGet('categoria');
        $categoriaId = (is_string($categoria) && ctype_digit($categoria) && (int) $categoria > 0) ? (int) $categoria : null;

        $lista = (new ProductoModel())->activosConCategoria($categoriaId);

        return $this->response
            ->setStatusCode(200)
            ->setJSON(['status' => 'success', 'total' => count($lista), 'data' => $lista]);
    }

    public function show($id = null)
    {
        $producto = (new ProductoModel())->detalle((int) $id);

        if ($producto === null) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['status' => 'error', 'message' => 'Producto no encontrado.']);
        }

        return $this->response
            ->setStatusCode(200)
            ->setJSON(['status' => 'success', 'data' => $producto]);
    }
}
