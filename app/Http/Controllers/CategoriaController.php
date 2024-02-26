<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Libreria importada

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cine = Categoria::all(); // Utiliza el método all() para obtener todos los registros
        return response()->json(['cine' => $cine]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validateTipo = Validator::make(
            $request->all(),
            [
                'lugar' => 'required',
                'nombre' => 'required',
            ]
        );

        if ($validateTipo->fails()) {
            return response()->json([
                'estado' => false,
                'message' => 'Existen campos vacíos',
                'errors' => $validateTipo->errors()
            ], 401);
        }

        try {
            $cine = categoria::create([
                'lugar' => $request->lugar,
                'nombre' => $request->nombre,
            ]);

            return response()->json([
                'cine' => $cine,
                'message' => 'cine creado correctamente',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al crear el gasto: ',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //ELIMINADO DE LA BASE DE DATOS
    {
  
}
}