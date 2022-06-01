<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcampoFormatJson extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'abreviatura' => $this->getAbreviatura(),
            'es_compuesto' => $this->esCompuesto(),
            'orden' => $this->getOrden(),
        ];
    }
}
