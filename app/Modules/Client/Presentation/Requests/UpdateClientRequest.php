<?php

namespace App\Modules\Client\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $client = auth('client')->user();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:clients,email,' . $client?->id],
            'password' => ['nullable', 'string', 'min:8'],
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
            'delete_path_image' => ['nullable', 'boolean'],
        ];
    }
}
