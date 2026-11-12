<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Modules\Client\Business\ClientService;
use App\Modules\Client\DTO\ClientData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function __construct(protected ClientService $service) {}

    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->clientData($this->client($request)),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $client = $this->client($request);
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => [
                'sometimes',
                'required',
                'string',
                'max:15',
                Rule::unique('clients', 'phone')
                    ->where('tenant_id', $client->tenant_id)
                    ->ignore($client->id),
            ],
            'email' => [
                'sometimes',
                'nullable',
                'email',
                'max:255',
                Rule::unique('clients', 'email')->ignore($client->id),
            ],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
            'path_image' => ['sometimes', 'nullable', 'file', 'image', 'max:2048'],
            'delete_path_image' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Os dados informados são inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $changes = $validator->validated();

        if (! $changes && ! $request->hasFile('path_image')) {
            return response()->json([
                'message' => 'Informe ao menos um dado para atualizar.',
            ], 422);
        }

        $clientData = ClientData::fromArray(array_merge([
            'name' => $client->name,
            'phone' => $client->phone,
            'email' => $client->email,
            'active' => $client->active,
        ], $changes));

        $this->service->update(
            $client,
            $clientData,
            $request->file('path_image')
        );

        return response()->json([
            'message' => 'Dados atualizados com sucesso.',
            'data' => $this->clientData($client->fresh()),
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $client = $this->client($request);
        $client->tokens()->delete();
        $this->service->delete($client);

        return response()->json(['message' => 'Conta excluída com sucesso.']);
    }

    private function client(Request $request): Client
    {
        $client = $request->user();

        abort_unless($client instanceof Client, 401, 'Não autenticado.');

        return $client;
    }

    private function clientData(Client $client): array
    {
        return [
            'id' => $client->id,
            'name' => $client->name,
            'phone' => $client->phone,
            'email' => $client->email,
            'path_image' => $client->path_image,
        ];
    }
}
