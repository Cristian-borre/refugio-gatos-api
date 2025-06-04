<?php

namespace App\Http\Controllers;

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

        if ($request->has('busqueda') && $request->busqueda != '') {
            $busqueda = $request->busqueda;
            $query->where('nombre', 'like', "%{$busqueda}%");
        }

        $gatos = $query->paginate($request->input('limit', 10));

        return response()->json($gatos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'raza' => 'nullable|string|max:255',
            'collar' => 'required|integer|unique:gatos,collar',
            'estado' => 'in:disponible,adoptado',
        ]);

        $gato = Gato::create($validated);

        return response()->json($gato, 201);
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

        return response()->json($gato, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gato = Gato::find($id);

        if (!$gato) {
            return response()->json(['error' => 'Gato no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'edad' => 'sometimes|required|integer|min:0',
            'raza' => 'nullable|string|max:255',
            'collar' => 'sometimes|required|integer|unique:gatos,collar,' . $gato->id,
            'estado' => 'in:disponible,adoptado',
        ]);

        $gato->update($validated);

        return response()->json($gato, 200);
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

        $gato->delete();

        return response()->json(['message' => 'Gato eliminado correctamente'], 200);
    }
}
