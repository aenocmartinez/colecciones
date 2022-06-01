<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Compartido\MensajeJson;
use Src\Compartido\messsage\Error;
use Src\Compartido\messsage\JSONMessage;
use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class AgregarSubcampoUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(int $campoId, int $subcampoId, int $orden=1): MensajeJson {
        
        $campo = Campo::buscarPorId($this->repository, $campoId);
        if (!$campo->existe()) {
            return new MensajeJson("200", "error", "El campo principal no existe.");
        }
        
        $subcampo = Campo::buscarPorId($this->repository, $subcampoId);
        if (!$subcampo->existe()) {
            return new MensajeJson("200", "error", "El subcampo no existe.");
        }
        
        if (!$campo->esCompuesto()) {
            return new MensajeJson("200", "error", "El campo principal no es compuesto.");
        }
        
        $campo->setRepository($this->repository);
        $exito = $campo->agregarSubcampo($subcampo, $orden);
        
        $mensajeJson = new MensajeJson("200", "success", "Se ha asigando el subcampo exitosamente.");
        if (!$exito) {
            $mensajeJson = new MensajeJson("502", "error", "Ha ocurrido un error en el sistema.");
        }

        return $mensajeJson;
    }
}
