<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * CONTROLADOR del catálogo: recibe la petición, le pide los datos a los
 * modelos y devuelve una vista (plantilla del framework).
 */
class Catalogo extends BaseController
{
    protected $helpers = ['url'];                      // base_url(), site_url()

    /** GET /catalogo  y  GET /catalogo?categoria=2 */
    public function index(): string
    {
        $productos  = new ProductoModel();
        $categorias = new CategoriaModel();

        // ?categoria=N  (solo se acepta un entero positivo)
        $categoria   = $this->request->getGet('categoria');
        $categoriaId = (is_string($categoria) && ctype_digit($categoria) && (int) $categoria > 0) ? (int) $categoria : null;

        return view('catalogo/index', [
            'titulo'      => 'Catálogo',
            'productos'   => $productos->activosConCategoria($categoriaId),
            'categorias'  => $categorias->orderBy('nombre', 'ASC')->findAll(),
            'categoriaId' => $categoriaId,
            'resumen'     => $productos->resumen(),
        ]);
    }

    /** GET /catalogo/3 */
    public function ver($id = null): string
    {
        $producto = (new ProductoModel())->detalle((int) $id);

        if ($producto === null) {
            throw PageNotFoundException::forPageNotFound('El producto no existe.');   // responde 404
        }

        return view('catalogo/detalle', [
            'titulo'   => $producto['nombre'],
            'producto' => $producto,
        ]);
    }
}
