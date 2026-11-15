<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\NormalizesProductPrices;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductUpdateRequest extends FormRequest
{
    use NormalizesProductPrices;

     public function authorize(): bool
    {
        if(!Auth::user()->hasRole('Super') && 
        !Auth::user()->can('usuario.tornar usuario master') && 
        !(Auth::user()->can('produtos.visualizar') && Auth::user()->can('produtos.editar'))){
            return false;
        }
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'active' => $this->boolean('active'),
        ] + $this->normalizeProductPrices());
    }

    public function rules(): array
    {
        return array_merge([
            'sizes'   => 'array|nullable',
            'sizes.*' => 'string|max:50|nullable',
            'path_image' => ['nullable', 'file', 'image', 'max:2048', 'mimes:jpg,jpeg,png,gif'],
            'path_file' => ['nullable', 'file', 'max:3072'],
            'active' => 'boolean',
            'sorting' => ['nullable', 'integer'],
        ], $this->productCompositionRules());
    }

    public function messages()
    {
        return [
            'price.required' => 'Informe o preço de venda.',
            'price.required_with' => 'Informe o preço de venda.',
            'price.numeric' => 'Informe um preço de venda válido.',
            'price.min' => 'O preço de venda não pode ser negativo.',
            'old_price.numeric' => 'Informe um preço anterior válido.',
            'options.*.choices.*.name.required' => 'Informe o nome de cada escolha da personalização.',
            'options.*.choices.*.price.numeric' => 'Informe um preço válido para cada escolha.',
            'combo_addons.*.price.numeric' => 'Informe um preço válido para cada adicional.',
            'path_image.max' => 'A imagem deve ter no máximo 2MB.',
            'path_file.max' => 'A imagem deve ter no máximo 3MB.',
        ];
    }
}
