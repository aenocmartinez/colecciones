<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class ListarCamposUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(): array {
        return Campo::listar($this->repository);
    }
}
