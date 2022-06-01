<?php
declare(strict_types=1);

use Src\Museologo\domain\repositories\ColeccionRepository;

class Coleccion {
    private ColeccionRepository $repository;
    private int $id;
    private string $nombre;

    public function setRepository(ColeccionRepository $repository) {
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

    public function existe(): bool {
        return $this->nombre != "";
    }

    public function crear(): bool {
        return $this->repository->crear($this);
    }

    public function eliminar(): bool {
        return $this->repository->eliminar($this->getId());
    }

    public function actualizar(): bool {
        return $this->repository->actualizar($this);
    }

    public static function buscarPorId(ColeccionRepository $repository, int $coleccionId): Coleccion {
        return $repository->buscarPorId($coleccionId);
    }

    public static function listar(ColeccionRepository $repository): array {
        return $repository->listar();
    }
}