<?php
declare(strict_types=1);

namespace Src\Museologo\domain\entity;

use Src\Museologo\domain\repositories\CampoRepository;

abstract class Campo {
    protected int $id;
    protected string $nombre;
    protected string $descripcion;
    protected string $abreviatura;
    protected CampoRepository $repository;

    public function __construct() {
        $this->nombre = "";
        $this->descripcion = "";
        $this->abreviatura = "";
    }

    public function setRepository(CampoRepository $repository): void {
        $this->repository = $repository;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setAbreviatura(string $abreviatura): void {
        $this->abreviatura = $abreviatura;
    }

    public function getAbreviatura(): string {
        return $this->abreviatura;
    }

    public function crear(): booL {
        return $this->repository->crear($this);
    }

    public static function listar(CampoRepository $repository): array {
        return $repository->listar();
    }

    public function eliminar(): booL {
        return $this->repository->eliminar($this->getId());
    }

    public function actualizar(): booL {
        return $this->repository->actualizar($this);
    }

    public static function buscarPorId(CampoRepository $repository, int $campoId): Campo {
        return $repository->buscarPorId($campoId);
    }

    public function existe(): bool {
        return strlen($this->nombre) > 0;
    }

    abstract public function esCompuesto(): bool;
}
