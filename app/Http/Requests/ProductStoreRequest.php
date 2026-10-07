<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        if(!Auth::user()->hasRole('Super') && 
        !Auth::user()->can('usuario.tornar usuario master') && 
        !(Auth::user()->can('produtos.visualizar') && Auth::user()->can('produtos.criar'))){
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
            'sizes'   => 'array|nullable',
            'sizes.*' => 'string|max:50|nullable',
            'path_image' => ['nullable', 'file', 'image', 'max:2048', 'mimes:jpg,jpeg,png,gif'],
            'path_file' => ['nullable', 'file', 'max:3072'],
            'active' => 'boolean',
            'sorting' => ['nullable', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'path_image.max' => 'A imagem deve ter no máximo 2MB.',
            'path_file.max' => 'A imagem deve ter no máximo 3MB.',
        ];
    }
}
