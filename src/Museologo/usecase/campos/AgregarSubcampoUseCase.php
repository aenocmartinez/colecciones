<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class AgregarSubcampoUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(int $campoId, int $subcampoId, int $orden=1): bool {
        $campo = Campo::buscarPorId($this->repository, $campoId);
        if (!$campo->existe()) {
            return false;
        }

        $subcampo = Campo::buscarPorId($this->repository, $subcampoId);
        if (!$subcampo->existe()) {
            return false;
        }

        if (!$campo->esCompuesto()) {
            return false;
        }

        $campo->setRepository($this->repository);
        return $campo->agregarSubcampo($subcampo, $orden);
    }
}
