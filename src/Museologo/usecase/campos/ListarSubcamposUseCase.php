<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class ListarSubcamposUseCase {
    private CampoRepository $repository;

    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(int $campoId): array {
        $subcampos = array();
        $campo = Campo::buscarPorId($this->repository, $campoId);
        if (!$campo->existe()) {
            return $subcampos;
        }

        if (!$campo->esCompuesto()) {
            return $subcampos;
        }

        $campo->setRepository($this->repository);
        return $campo->listarSubcampos();
    }
}
