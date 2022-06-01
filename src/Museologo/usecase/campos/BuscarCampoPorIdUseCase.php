<?php
declare(strict_types=1);

namespace Src\Museologo\usecase\campos;

use Src\Compartido\MensajeJson;
use Src\Museologo\domain\entity\Campo;
use Src\Museologo\domain\repositories\CampoRepository;

class BuscarCampoPorIdUseCase {
    private CampoRepository $repository;
    public function __construct(CampoRepository $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(int $campoId): MensajeJson {        
        $campo = Campo::buscarPorId($this->repository, $campoId);
        if (!$campo->existe()) {
            return new MensajeJson("200", "error", "El campo no existe.");
        }

        $mensajeJson = new MensajeJson("200", "success", "");
        $mensajeJson->data = $campo;
        return $mensajeJson;
    }
}
