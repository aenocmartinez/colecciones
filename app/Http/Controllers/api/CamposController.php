<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgregarSubcampoRequest;
use App\Http\Requests\GuardarCampoRequest;
use App\Http\Resources\CampoFormatoJson;
use App\Http\Resources\SubcampoFormatJson;
use Src\Museologo\domain\dto\CampoDto;
use Src\Museologo\infraestructure\repository\eloquent\Campo as EloquentCampo;
use Src\Museologo\usecase\campos\ActualizarCampoUseCase;
use Src\Museologo\usecase\campos\AgregarSubcampoUseCase;
use Src\Museologo\usecase\campos\BuscarCampoPorIdUseCase;
use Src\Museologo\usecase\campos\CrearCampoUseCase;
use Src\Museologo\usecase\campos\EliminarCampoUseCase;
use Src\Museologo\usecase\campos\ListarCamposUseCase;
use Src\Museologo\usecase\campos\ListarSubcamposUseCase;
use Src\Museologo\usecase\campos\QuitarSubcampoUseCase;

class CamposController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
        
    public function index() {
        $casoUso = new ListarCamposUseCase(new EloquentCampo());
        $campos = $casoUso->ejecutar();
        return response()->json([
            "data" => CampoFormatoJson::collection($campos)
        ]);
    }

    public function create() {
        //
    }

    public function store(GuardarCampoRequest $req) {
        $campoDto = new CampoDto();
        $campoDto->nombre = $req->nombre;
        $campoDto->descripcion = $req->descripcion;
        $campoDto->abreviatura = "";
        if (strlen($req->abreviatura)>0) {
            $campoDto->abreviatura = $req->abreviatura;
        }
        $campoDto->esCompuesto = $req->es_compuesto;

        $casoUso = new CrearCampoUseCase(new EloquentCampo());
        $exito = $casoUso->ejecutar($campoDto);
        if ($exito) {
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'Error'
            ]);
        }
    }

    public function show($campoId) {
        $casoUso = new BuscarCampoPorIdUseCase(new EloquentCampo());
        $campo = $casoUso->ejecutar($campoId);
        if (!$campo->existe()) {
            return response()->json([
                'code' => 200,
                'message' => 'El campo no existe'
            ]);
        }
        return response()->json(new CampoFormatoJson($campo));
    }

    public function edit($id) {
        //
    }

    public function update(GuardarCampoRequest $req, $campoId) {
        $campoDto = new CampoDto();
        $campoDto->nombre = $req->nombre;
        $campoDto->descripcion = $req->descripcion;
        $campoDto->abreviatura = "";
        if (strlen($req->abreviatura)>0) {
            $campoDto->abreviatura = $req->abreviatura;
        }
        $campoDto->esCompuesto = $req->es_compuesto;
        $campoDto->id = $campoId;

        $casoUso = new ActualizarCampoUseCase(new EloquentCampo());
        $exito = $casoUso->ejecutar($campoDto);
        if ($exito) {
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'Error'
            ]);
        }
    }
    public function destroy($id) {
        if (!is_numeric($id)) {
            return response()->json([
                'code' => 200,
                'message' => 'parámetro no válido'
            ]);
        }

        $casoUso = new EliminarCampoUseCase(new EloquentCampo());
        $exito = $casoUso->ejecutar($id);
        if ($exito) {
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'el campo no existe'
            ]);
        }
    }

    public function agregarSubcampo(AgregarSubcampoRequest $req) {
        $casoUso = new AgregarSubcampoUseCase(new EloquentCampo());
        $exito = $casoUso->ejecutar($req->campo_id, $req->subcampo_id, $req->orden);
        if ($exito) {
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'el campo no existe'
            ]);
        }
    }

    public function quitarSubcampo(AgregarSubcampoRequest $req) {
        $casoUso = new QuitarSubcampoUseCase(new EloquentCampo());
        $exito = $casoUso->ejecutar($req->campo_id, $req->subcampo_id);
        if ($exito) {
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'el campo no existe'
            ]);
        }
    }

    public function listarSubcampos(int $campoId) {
        $casoUso = new ListarSubcamposUseCase(new EloquentCampo());
        $subcampos = $casoUso->ejecutar($campoId);
        return response()->json([
            "data" => SubcampoFormatJson::collection($subcampos)
        ]);
    }
}
