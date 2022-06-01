<?php
declare(strict_types=1);

namespace Src\Museologo\domain\dto;

class CampoDto {
    public int $id;
    public string $nombre;
    public string $descripcion;
    public string $abreviatura;
    public bool $esCompuesto;
}
