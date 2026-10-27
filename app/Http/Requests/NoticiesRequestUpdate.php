<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class NoticiesRequestUpdate extends FormRequest
{
    public function authorize(): bool
    {
        if(!Auth::user()->hasRole('Super') && 
        !Auth::user()->can('usuario.tornar usuario master') && 
        !Auth::user()->can('editais.editar')){
            return false;
        }
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active') ? 1 : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'active' => 'boolean',
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
