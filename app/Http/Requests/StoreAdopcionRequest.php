<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdopcionRequest extends FormRequest
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
    public function rules()
    {
        return [
            'cedula' => 'required|string',
            'name' => 'required_if:nuevo,true',
            'email' => 'required_if:nuevo,true|email',
            'gato_id' => 'required|exists:gatos,id',
            'nuevo' => 'boolean'
        ];
    }
}
