<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    protected function prepareForValidation() {
        $this->merge([
            'role_id'        => (is_array($this->role_id))        ? validate_data($this->role_id, 'integer_array')        : validate_data([$this->role_id], 'integer_array'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name'             => 'required|min:3|max:255',
            'password'         => 'required|confirmed|min:6|max:255',
            'email'            => 'required|email|max:255|unique:App\Models\Settings\User,email',
            'status'           => 'nullable|in:1,2,3',
            'role_id.*'        => 'required|exists:roles,id',
        ];
    }

    public function attributes() {
        return [
            'name'           => 'El nombre',
            'password'       => 'La contraseña',
            'email'          => 'El correo electrónico',
            'status'         => 'El estado',
            'role_id'        => 'El rol',
        ];
    }

    public function messages() {
        return [
            'array'                   => ':attribute debe ser un array válido.',
            'exists'                  => ':attribute no existe.',
            'role_id.exists'          => ':attribute no existe.',
            'max'                     => ':attribute debe contener un máximo de 255 carácteres',
            'string'                  => ':attribute debe ser una cadena de carácteres válida',
            'email'                   => ':attribute debe ser un correo electrónico válido.',
            'required'                => ':attribute es un campo requerido.',
            'name.min'                => ':attribute debe contener un mínimo de 3 carácteres.',
            'email.unique'            => ':attribute ya se encuentra registrado.',
            'password.min'            => ':attribute debe contener un mínimo de 6 carácteres.',
            'status.in'               => ':attribute debe ser igual a uno de los siguientes valores: 1, 2 o 3',
            'confirmed'               => ':attribute debe tener un campo de nombre <password_confirmation> cuyo valor será idéntico al campo <password>',
        ];
    }
}
