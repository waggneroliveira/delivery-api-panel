<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class BlogRequestUpdate extends FormRequest
{
    public function authorize(): bool
    {
        if(!Auth::user()->hasRole('Super') && 
        !Auth::user()->can('usuario.tornar usuario master') && 
        !Auth::user()->can('noticias.editar')){
            return false;
        }
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active') ? 1 : 0,
            'super_highlight' => $this->has('super_highlight') ? 1 : 0,
            'highlight' => $this->has('highlight') ? 1 : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['nullable', 'string'],
            'path_image' => ['nullable', 'file', 'image', 'max:2048', 'mimes:jpg,jpeg,png,gif'],
            'active' => 'boolean',
            'super_highlight' => 'boolean',
            'highlight' => 'boolean',
            'sorting' => ['nullable', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo Título é obrigatório.',
        ];
    }
}
