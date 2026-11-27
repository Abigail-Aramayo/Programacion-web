<?php

namespace App\Models;

use CodeIgniter\Model;

/** MODELO de categorías: tabla `categorias` del TP6. */
class CategoriaModel extends Model
{
    protected $table         = 'categorias';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['nombre', 'descripcion'];
}
