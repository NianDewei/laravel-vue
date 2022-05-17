<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablecimientoUpdateRequest extends FormRequest
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
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Models\Categoria,id',
            'imagen_principal' => 'image|max:1000',
            'direccion' => 'required',
            'cuadra' => 'required',
            'lat'   => 'required',
            'lng' => 'required',
            'telefono'  => 'required|numeric',
            'descripcion'   => 'required',
            'apertura'   => 'required|date_format:H:i',
            'cierre'   => 'required|date_format:H:i|after:apertura',
            'uuid'   => 'required|uuid',
            // 'user_id'   => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'categoria_id' => 'categoría',
        ];
    }

}
