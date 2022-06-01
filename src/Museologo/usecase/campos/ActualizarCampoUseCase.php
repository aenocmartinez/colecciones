<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Museologo\domain\dto\CampoDto;
use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class ActualizarCampoUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(CampoDto $campoDto): bool {
        $campo = Campo::buscarPorId($this->repository, $campoDto->id);
        if (!$campo->existe()) {
            return false;
        }

        $campo->setNombre($campoDto->nombre);
        $campo->setDescripcion($campoDto->descripcion);
        $campo->setAbreviatura($campoDto->abreviatura);
        $campo->setRepository($this->repository);
        return $campo->actualizar();
    }
}
