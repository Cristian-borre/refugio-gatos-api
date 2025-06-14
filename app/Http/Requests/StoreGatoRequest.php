<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGatoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'raza' => 'nullable|string|max:255',
            'collar' => 'required|integer|unique:gatos,collar',
            'estado' => 'in:disponible,adoptado',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'edad.integer' => 'La edad debe ser un número.',
            'collar.unique' => 'Este número de collar ya está registrado.',
        ];
    }
}
