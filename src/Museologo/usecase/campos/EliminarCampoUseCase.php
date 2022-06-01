<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class EliminarCampoUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository){
        $this->repository = $repository;
    }

    public function ejecutar(int $campoId): bool {
        $campo = Campo::buscarPorId($this->repository, $campoId);
        if (!$campo->existe()) {
            return false;
        }

        $campo->setRepository($this->repository);
        return $campo->eliminar();
    }
}
