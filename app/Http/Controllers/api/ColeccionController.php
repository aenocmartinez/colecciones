<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColeccionController extends Controller
{
    public function index()
    {
        $colecciones = array(
            array("id" => 1, "nombre" => 'Arte'),
            array("id" => 2, "nombre" => 'Historia'),
            array("id" => 3, "nombre" => 'Arqueología'),
            array("id" => 4, "nombre" => 'Etnografía'),
        );

        return response()->json([
            "data" => $colecciones
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $req)
    {
        return response()->json([
            "Nueva colección" => $req->nombre
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
