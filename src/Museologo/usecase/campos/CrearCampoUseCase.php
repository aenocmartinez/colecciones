<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Compartido\MensajeJson;
use Src\Museologo\domain\dto\CampoDto;
use Src\Museologo\domain\entity\CampoCompuesto;
use Src\Museologo\domain\entity\CampoSimple;
use Src\Museologo\domain\repositories\CampoRepository;

class CrearCampoUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(CampoDto $campoDto): MensajeJson {
        $campo = new CampoSimple();
        if ($campoDto->esCompuesto) {
            $campo = new CampoCompuesto();
        }
        $campo->setNombre($campoDto->nombre);
        $campo->setAbreviatura($campoDto->abreviatura);
        $campo->setDescripcion($campoDto->descripcion);
        $campo->setRepository($this->repository);

        $exito = $campo->crear();
        
        $mensajeJson = new MensajeJson("200", "success", "Se ha creado el campo exitosamente.");
        if (!$exito) {
            $mensajeJson = new MensajeJson("502", "error", "Ha ocurrido un error en el sistema.");
        }        
        return $mensajeJson;
    }
}
