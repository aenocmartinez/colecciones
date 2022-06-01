<?php
declare(strict_types=1);

namespace Src\Museologo\domain\repositories;

use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\entity\Subcampo;

interface CampoRepository {
    public function crear(Campo $campo): booL;
    public function listar(): array;
    public function eliminar(int $campoId): bool;
    public function actualizar(Campo $campo): bool;
    public function buscarPorId(int $campoId): Campo;
    public function agregarSubcampo(Campo $campo, Subcampo $subcampo): bool;
    public function quitarSubcampo(Campo $campo, Subcampo $subcampo): bool;
    public function listarSubcampos(int $campoId): array;
}
