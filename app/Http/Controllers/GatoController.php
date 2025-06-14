<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGatoRequest;
use App\Http\Requests\UpdateGatoRequest;
use App\Http\Resources\GatoResource;
use App\Models\Gato;
use Illuminate\Http\Request;

class GatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Gato::query();

        if ($request->filled('busqueda')) {
            $query->where('nombre', 'like', "%{$request->busqueda}%");
        }

        $gatos = $query->paginate($request->input('limit', 10));

        return GatoResource::collection($gatos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGatoRequest $request)
    {
        try {
            $gato = Gato::create($request->validate());
            return (new GatoResource($gato))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al guardar el gato.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gato = Gato::find($id);

        if (!$gato) {
            return response()->json(['error' => 'Gato no encontrado'], 404);
        }

        return new GatoResource($gato);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGatoRequest $request, Gato $gato)
    {
        try {
            $gato->update($request->validate());
            return new GatoResource($gato);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al actualizar el gato.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gato = Gato::find($id);

        if (!$gato) {
            return response()->json(['error' => 'Gato no encontrado'], 404);
        }

        try {
            $gato->delete();
            return response()->json(['message' => 'Gato eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar el gato.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }
}
