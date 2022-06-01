<?php
declare(strict_types=1);

namespace Src\Compartido;

class MensajeJson {
    public string $codigo;
    public string $tipo;
    public string $detalle;
    public $data;
    public function __construct(string $codigo, string $tipo, string $detalle){
        $this->codigo = $codigo;
        $this->tipo = $tipo;
        $this->detalle = $detalle;
    }
}