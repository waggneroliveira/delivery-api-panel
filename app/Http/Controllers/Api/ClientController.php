<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Modules\Client\Business\ClientService;
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
            'phone' => ['sometimes', 'required', 'string', 'max:15'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('clients', 'email')->ignore($client->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Os dados informados são inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $changes = $validator->validated();

        if (! $changes) {
            return response()->json([
                'message' => 'Informe ao menos um dado para atualizar.',
            ], 422);
        }

        $client->fill($changes)->save();

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
