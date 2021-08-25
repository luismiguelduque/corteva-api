<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    // protected function prepareForValidation() {
    //     $this->merge([
    //         'slug' => Str::slug($this->slug),
    //     ]);
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email'    => 'required|string|email',
            'password' => 'required|string|min:6',
        ];
    }

    public function attributes() {
        return [
            'email'    => 'El correo electrónico',
            'password' => 'La contraseña',
        ];
    }

    public function messages() {
        return [
            'max'          => ':attribute debe contener un máximo de 255 carácteres',
            'email'        => ':attribute debe ser un correo electrónico válido.',
            'string'       => ':attribute debe ser una cadena de carácteres válida', 
            'required'     => ':attribute es un campo requerido.',
            'confirmed'    => ':attribute debe tener un campo coincidente del tipo password_confirmation',
            'name.min'     => ':attribute debe contener un mínimo de 3 carácteres.',
            'email.unique' => ':attribute ya se encuentra registrado.',
            'password.min' => ':attribute debe contener un mínimo de 6 carácteres.',
        ];
    }
}
