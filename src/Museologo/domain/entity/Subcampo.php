<?php
declare(strict_types=1);

namespace Src\Museologo\domain\entity;

class Subcampo {
    private Campo $campo;
    private int $orden;

    public function __construct(Campo $campo, int $orden = 1) {
        $this->campo = $campo;
        $this->orden = $orden;
    }

    public function getId(): int {
        return $this->campo->getId();
    }

    public function getNombre(): string {
        return $this->campo->getNombre();
    }

    public function getDescripcion(): string {
        return $this->campo->getDescripcion();
    }

    public function getAbreviatura(): string {
        return $this->campo->getAbreviatura();
    }

    public function esCompuesto(): bool {
        return $this->campo->esCompuesto();
    }

    public function getOrden(): int {
        return $this->orden;
    }
}
