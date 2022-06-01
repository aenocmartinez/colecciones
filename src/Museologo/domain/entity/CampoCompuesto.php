<?php
declare(strict_types=1);

namespace Src\Museologo\domain\entity;

class CampoCompuesto extends Campo {

    public function agregarSubcampo(Campo $subcampo, int $orden = 1): bool {
        $this->repository->quitarSubcampo($this, new Subcampo($this));
        return $this->repository->agregarSubcampo($this, new Subcampo($subcampo, $orden) );
    }

    public function quitarSubcampo(Campo $subcampo): bool {
        return $this->repository->quitarSubcampo($this, new Subcampo($subcampo));
    }

    public function listarSubcampos(): array {
        return  $this->repository->listarSubcampos($this->getId());
    }

    public function totalSubcampos(): int {
        return count($this->listarSubcampos());
    }

    public function esCompuesto(): bool {
        return true;
    }
}
