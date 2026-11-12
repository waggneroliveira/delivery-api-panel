<?php

namespace App\Modules\Client\Presentation\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $routeClient = $this->route('client');
        $clientId = $routeClient instanceof Client
            ? $routeClient->id
            : auth('client')->id();

        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'max:255', 'unique:clients,email,' . $clientId],
            'password' => ['nullable', 'string', 'min:8'],
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
            'delete_path_image' => ['nullable', 'boolean'],
        ];
    }
}
