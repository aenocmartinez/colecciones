<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class BuscarCampoPorIdUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(int $campoId): Campo {
        return Campo::buscarPorId($this->repository, $campoId);
    }
}
