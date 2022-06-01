<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Museologo\domain\dto\CampoDto;
use Src\Museologo\domain\entity\CampoCompuesto;
use Src\Museologo\domain\entity\CampoSimple;
use Src\Museologo\domain\repositories\CampoRepository;

class CrearCampoUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(CampoDto $campoDto): bool {
        $campo = new CampoSimple();
        if ($campoDto->esCompuesto) {
            $campo = new CampoCompuesto();
        }
        $campo->setNombre($campoDto->nombre);
        $campo->setAbreviatura($campoDto->abreviatura);
        $campo->setDescripcion($campoDto->descripcion);
        $campo->setRepository($this->repository);

        return $campo->crear();
    }
}
