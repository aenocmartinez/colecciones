<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class QuitarSubcampoUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(int $campo_id, int $subcampo_id): bool {
        $campo = Campo::buscarPorId($this->repository, $campo_id);
        if (!$campo->existe()) {
            return false;
        }

        $subcampo = Campo::buscarPorId($this->repository, $subcampo_id);
        if (!$subcampo->existe()) {
            return false;
        }

        if (!$campo->esCompuesto()) {
            return false;
        }

        $campo->setRepository($this->repository);
        return $campo->quitarSubcampo($subcampo);
    }
}
