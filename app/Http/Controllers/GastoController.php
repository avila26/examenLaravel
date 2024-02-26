<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use App\Models\gasto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Libreria importada

class GastoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
         $habitaciones = gasto::all();
        return response()->json(['habitaciones' => $habitaciones], 200);

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
        $validateHabitaciones = Validator::make(
            $request->all(),
            [
                'numeroHabitacion' => 'required',
                'numeroAsientos' => 'required', 
                'pelicula' => 'required',
                'cine_id' => 'required'
            ]
        );
        
        if ($validateHabitaciones->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Existen campos vacíos',
                'errors' => $validateHabitaciones->errors()
            ], 401);
        }
        
        try {
            $habitaciones = Gasto::create([
                'numeroHabitacion' => $request->numeroHabitacion,
                'numeroAsientos' => $request->numeroAsientos,
                'pelicula' => $request->pelicula,
                'cine_id' => $request->cine_id,
            ]);
        
            return response()->json([
                'habitaciones' => $habitaciones,
                'message' => 'habitaciones creado correctamente',
            ], 201);
        } 
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al crear el gasto: ',
            ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $gasto = gasto::with('categoria')->get();
        return response()->json($gasto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(gasto $gasto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, gasto $gasto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(gasto $gasto)
    {
        //
    }

    public function reservarAsientos(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'gasto_id' => 'required|exists:gastos,id',
            'cantidad_reservada' => 'required|integer|min:1',
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'estado' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Obtener el gasto
            $gasto = Gasto::findOrFail($request->gasto_id);

            // Calcular la cantidad de asientos disponibles
            $asientos_disponibles = $gasto->numeroAsientos;

            // Comprobar si hay suficientes asientos disponibles
            if ($asientos_disponibles < $request->cantidad_reservada) {
                return response()->json([
                    'estado' => false,
                    'message' => 'No hay suficientes asientos disponibles para reservar',
                    'asientos_disponibles' => $asientos_disponibles,
                ], 400);
            }

            // Actualizar la cantidad de asientos disponibles
            $gasto->update([
                'numeroAsientos' => $asientos_disponibles - $request->cantidad_reservada,
            ]);

            // Retornar una respuesta de éxito
            return response()->json([
                'message' => 'Reserva de asientos realizada correctamente',
                'asientos_disponibles' => $asientos_disponibles - $request->cantidad_reservada,
            ], 201);
        } catch (\Exception $e) {
            // En caso de error, retornar una respuesta de error
            return response()->json([
                'status' => false,
                'message' => 'Error al reservar asientos: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function buscar(Request $request, $habitaciones)
    {
        try {
            // Buscar la categoría en la base de datos
            $categoriaEncontrada = Categoria::where('nombre', $habitaciones)
                                            ->where('estado', true)
                                            ->first();

            if (!$categoriaEncontrada) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }

            // Obtener todos los gastos que pertenecen a esta categoría
            $gastos = Gasto::where('cine_id', $categoriaEncontrada->id)
                           ->where('estado', true)
                           ->get();

            // Verificar si se encontraron gastos para esta categoría
            if ($gastos->isEmpty()) {
                return response()->json(['message' => 'No se encontraron gastos para esta categoría'], 404);
            }

            // Devolver los gastos encontrados
            return response()->json(['message' => 'Gastos encontrados para la categoría', 'categoria' => $categoriaEncontrada->nombre, 'gastos' => $gastos], 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }


}