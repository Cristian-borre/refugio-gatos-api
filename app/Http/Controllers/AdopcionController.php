<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAdopcionRequest;
use App\Http\Resources\AdopcionResource;
use App\Models\Adopciones;
use App\Models\User;
use App\Models\Gato;
use Illuminate\Support\Facades\Hash;

class AdopcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Adopciones::with('gato', 'adoptante');

        if ($request->filled('busqueda')) {
            $query->whereHas('adoptante', function ($q) use ($request) {
                $q->where('cedula', 'like', '%' . $request->busqueda . '%');
            });
        }

        $adopciones = $query->paginate($request->input('limit', 10));

        return AdopcionResource::collection($adopciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdopcionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdopcionRequest $request)
    {
        try {
            $data = $request->validated();
    
            $user = User::where('cedula', $data['cedula'])->first();
    
            if (!$user) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'cedula' => $data['cedula'],
                    'rol' => 'adoptante',
                    'password' => Hash::make('123456'),
                ]);
            }
    
            $adopcion = Adopciones::create([
                'user_id' => $user->id,
                'gato_id' => $data['gato_id'],
                'fecha_adopcion' => now(),
            ]);
    
            return (new AdopcionResource($adopcion))
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al guardar la adopción.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adopciones  $adopcion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adopcion = Adopciones::with('gato', 'adoptante')->find($id);

        if (!$adopcion) {
            return response()->json(['error' => 'Adopción no encontrada'], 404);
        }

        return new AdopcionResource($adopcion);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdopcionRequest  $request
     * @param  \App\Models\Adopciones  $adopcion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adopcion = Adopciones::find($id);

        if (!$adopcion) {
            return response()->json(['error' => 'Adopción no encontrada'], 404);
        }

        try {
            $adopcion->delete();
            return response()->json(['message' => 'Adopción eliminada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al eliminar la adopción.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }
}
