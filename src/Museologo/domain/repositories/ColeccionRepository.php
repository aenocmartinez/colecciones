<?php
declare(strict_types=1);

namespace Src\Museologo\domain\repositories;

use Coleccion;

interface ColeccionRepository {
    public function crear(Coleccion $coleccion): bool;
    public function eliminar(int $coleccionId): bool;
    public function buscarPorId(int $coleccionId): Coleccion;
    public function actualizar(Coleccion $coleccion): bool;
    public function listarColecciones(): array;    
}