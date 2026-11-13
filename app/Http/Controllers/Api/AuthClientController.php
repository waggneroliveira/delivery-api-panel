<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthClientController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->merge([
            'phone' => preg_replace('/\D/', '', $request->input('phone', '')),
        ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:11', 'regex:/^[0-9]+$/'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Os dados informados são inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $client = Client::query()
            ->where('phone', $data['phone'])
            ->first();

        if ($client) {
            return $this->authenticateExistingClient($client, $data['name']);
        }

        try {
            $client = Client::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => null,
                'password' => null,
                'active' => true,
            ]);
        } catch (QueryException $exception) {
            $client = Client::query()
                ->where('phone', $data['phone'])
                ->first();

            if (! $client) {
                throw $exception;
            }

            return $this->authenticateExistingClient($client, $data['name']);
        }

        return $this->issueToken($client, 'Conta criada e login realizado com sucesso.', 201);
    }

    private function authenticateExistingClient(Client $client, string $name): JsonResponse
    {
        if ($client->name !== $name) {
            return response()->json([
                'message' => 'O telefone informado já está associado a outro nome.',
            ], 409);
        }

        if (! $client->active) {
            return response()->json([
                'message' => 'Esta conta está inativa.',
            ], 403);
        }

        return $this->issueToken($client, 'Login realizado com sucesso.');
    }

    private function issueToken(Client $client, string $message, int $status = 200): JsonResponse
    {
        $token = $client->createToken('delivery')->plainTextToken;

        return response()->json([
            'message' => $message,
            'data' => [
                'token' => $token,
                'client' => $this->clientData($client),
            ],
        ], $status);
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json(['message' => 'Logout realizado com sucesso.']);
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
