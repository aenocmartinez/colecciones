<?php
declare(strict_types=1);

namespace Src\Museologo\domain\entity;

class CampoSimple extends Campo {
    public function esCompuesto(): bool {
        return false;
    }
}
