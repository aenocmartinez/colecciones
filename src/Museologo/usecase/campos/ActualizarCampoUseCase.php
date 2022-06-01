<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Compartido\MensajeJson;
use Src\Museologo\domain\dto\CampoDto;
use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class ActualizarCampoUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(CampoDto $campoDto): MensajeJson {
        $campo = Campo::buscarPorId($this->repository, $campoDto->id);
        if (!$campo->existe()) {
            return new MensajeJson("200", "error", "El campo principal no existe.");
        }

        $campo->setNombre($campoDto->nombre);
        $campo->setDescripcion($campoDto->descripcion);
        $campo->setAbreviatura($campoDto->abreviatura);
        $campo->setRepository($this->repository);
        $exito = $campo->actualizar();
        
        $mensajeJson = new MensajeJson("200", "success", "Se ha actualizado el campo exitosamente.");
        if (!$exito) {
            $mensajeJson = new MensajeJson("502", "error", "Ha ocurrido un error en el sistema.");
        }

        return $mensajeJson;        
    }
}
