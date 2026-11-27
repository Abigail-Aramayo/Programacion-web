<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * MODELO de categorías: toda la lógica de acceso a datos de la tabla `categorias`.
 */
class CategoriaModel
{
    public function __construct(private PDO $pdo) {}

    /** @return array<int, array{id:int, nombre:string}> */
    public function todas(): array
    {
        return $this->pdo->query('SELECT id, nombre FROM categorias ORDER BY nombre')->fetchAll();
    }

    public function existe(int $id): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM categorias WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
