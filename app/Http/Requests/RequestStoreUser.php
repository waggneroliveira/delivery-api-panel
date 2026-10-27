<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RequestStoreUser extends FormRequest
{
    public function authorize(): bool
    {
        if(!Auth::user()->hasRole('Super') && 
        !Auth::user()->can('usuario.tornar usuario master') && 
        !Auth::user()->can('usuario.visualizar')){
            return false;
        }
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'active' => $this->input('active') === 'on' ? 1 : 0,
        ]);
    }
    
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'active' => 'boolean',
            'sorting' => ['nullable', 'integer'],
            'roles'=>'array',
            'path_image' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,gif'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'path_image.max' => 'A imagem deve ter no máximo 2MB.',
            'path_image.mimes' => 'A imagem deve estar nos formatos: jpg, jpeg, png ou gif.',
        ];
    }
}
