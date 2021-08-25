<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
    public function rules() {
        return [
            'current_password'    => 'required|string',
            'new_password'        => 'required|string|min:8',
            'repeat_new_password' => 'required|string|min:8',
        ];
    }

    public function attributes() {
        return [
            'current_password'    => 'Contraseña actual',
            'new_password'        => 'Nueva contraseña',
            'repeat_new_password' => 'Repetir nueva contraseña',
        ];
    }

    public function messages() {
        return [
            'string'       => ':attribute debe ser una cadena de carácteres válida',
            'required'     => ':attribute es un campo requerido.',
            'min'          => ':attribute debe contener un mínimo de 8 carácteres.',
        ];
    }
}
