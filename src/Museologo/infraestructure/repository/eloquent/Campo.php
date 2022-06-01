<?php

namespace Src\Museologo\infraestructure\repository\eloquent;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Src\Museologo\domain\entity\Campo as EntityCampo;
use Src\Museologo\domain\entity\CampoCompuesto;
use Src\Museologo\domain\entity\CampoSimple;
use Src\Museologo\domain\entity\Subcampo;
use Src\Museologo\domain\repositories\CampoRepository;

class Campo extends Model implements CampoRepository {
    protected $table = "campos";
    protected $fillable = ['nombre', 'descripcion', 'abreviatura'];

    private function subcampos() {
        return $this->belongsToMany(Campo::class, 'subcampos', 'campo_id', 'subcampo_id')
                    ->withPivot(['orden'])
                    ->withTimestamps();
    }

    public function crear(EntityCampo $campo): bool {
        $exito = true;
        try {
            $nuevoCampo = Campo::create([
                'nombre' => $campo->getNombre(),
                'descripcion' => $campo->getDescripcion(),
                'abreviatura' => $campo->getAbreviatura()
            ]);

            if ($campo->esCompuesto()) {
                $campo->setId($nuevoCampo->id);
                $subcampo = new Subcampo($campo, 1);
                $exito = $this->agregarSubcampo($campo, $subcampo);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $exito = false;
        }
        return $exito;
    }

    public function listar(): array {
        $campos = array();
        try {
            $eloquentCampos =  DB::table('campos')
            ->leftJoin('subcampos', 'campos.id', '=', 'subcampos.campo_id')
            ->select('campos.id',
                    'campos.nombre',
                    'campos.descripcion',
                    'campos.abreviatura' ,
                    DB::raw('IF(subcampos.subcampo_id IS NULL, false, true) as esCompuesto'))
            ->distinct()
            ->get();

            foreach ($eloquentCampos as $eloquentCampo) {
                $campo = new CampoSimple();
                if ($eloquentCampo->esCompuesto) {
                    $campo = new CampoCompuesto();
                }
                $campo->setId($eloquentCampo->id);
                $campo->setNombre($eloquentCampo->nombre);
                $campo->setDescripcion($eloquentCampo->descripcion);
                $campo->setAbreviatura($eloquentCampo->abreviatura);
                array_push($campos, $campo);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $campos;
    }

    public function eliminar(int $campoId): bool {
        $exito = true;
        try {
            $eloquentCampo = Campo::find($campoId);
            if ($eloquentCampo) {
                $eloquentCampo->delete();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $exito = false;
        }
        return $exito;
    }

    public function actualizar(EntityCampo $campo): bool {
        $exito = true;
        try {
            $eloquentCampo = Campo::find($campo->getId());
            if ($eloquentCampo) {
                $eloquentCampo->nombre = $campo->getNombre();
                $eloquentCampo->descripcion = $campo->getDescripcion();
                $eloquentCampo->abreviatura = $campo->getAbreviatura();
                $eloquentCampo->save();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $exito = false;
        }
        return $exito;
    }

    public function buscarPorId(int $campoId): EntityCampo {
        $campo = new CampoSimple();
        try {
            $eloquentCampo =  DB::table('campos')
            ->leftJoin('subcampos', 'campos.id', '=', 'subcampos.campo_id')
            ->where('campos.id', '=', $campoId)
            ->select('campos.id',
                    'campos.nombre',
                    'campos.descripcion',
                    'campos.abreviatura' ,
                    DB::raw('IF(subcampos.subcampo_id IS NULL, false, true) as esCompuesto'))
            ->first();
            if ($eloquentCampo) {
                if ($eloquentCampo->esCompuesto) {
                    $campo = new CampoCompuesto();
                }
                $campo->setId($eloquentCampo->id);
                $campo->setNombre($eloquentCampo->nombre);
                $campo->setDescripcion($eloquentCampo->descripcion);
                $campo->setAbreviatura($eloquentCampo->abreviatura);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $campo;
    }

    public function agregarSubcampo(EntityCampo $campo, Subcampo $subcampo): bool {
        $exito = true;
        try {
            $eloquentCampo = Campo::find($campo->getId());
            if ($eloquentCampo) {
                $eloquentSubcampo = Campo::find($subcampo->getId());
                if ($eloquentSubcampo) {
                    $eloquentCampo->subcampos()->attach($eloquentSubcampo, ['orden' => $subcampo->getOrden()]);
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $exito = false;
        }
        return $exito;
    }

    public function quitarSubcampo(EntityCampo $campo, Subcampo $subcampo): bool {
        $exito = true;
        try {
            $eloquentCampo = Campo::find($campo->getId());
            if ($eloquentCampo) {
                $eloquentSubcampo = Campo::find($subcampo->getId());
                if ($eloquentSubcampo) {
                    $eloquentCampo->subcampos()->detach($eloquentSubcampo);
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $exito = false;
        }
        return $exito;
    }

    public function listarSubcampos(int $campoId): array {
        $subcampos = array();
        try {
            $eloquentSubcampos =  DB::table('campos')
            ->join('subcampos', 'campos.id', '=', 'subcampos.campo_id')
            ->join('campos as c2', 'c2.id', '=', 'subcampos.subcampo_id')
            ->select('c2.id',
                    'c2.nombre',
                    'c2.descripcion',
                    'c2.abreviatura' ,
                    'subcampos.orden',
                    DB::raw('false as esCompuesto'))
            ->where('campos.id', '=', $campoId)
            ->orderBy('subcampos.orden')
            ->get();

            foreach ($eloquentSubcampos as $eloquentCampo) {
                $campo = new CampoSimple();
                if ($eloquentCampo->esCompuesto) {
                    $campo = new CampoCompuesto();
                }
                $campo->setId($eloquentCampo->id);
                $campo->setNombre($eloquentCampo->nombre);
                $campo->setDescripcion($eloquentCampo->descripcion);
                $campo->setAbreviatura($eloquentCampo->abreviatura);
                $subcampo = new Subcampo($campo, $eloquentCampo->orden);
                array_push($subcampos, $subcampo);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $subcampos;
    }
}

// select c2.id, c2.nombre, c2.descripcion, c2.abreviatura, sc.orden
// from campos c

// where c.id = 10 order by sc.orden;
