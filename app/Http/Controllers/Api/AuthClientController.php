<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthClientController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Os dados informados são inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $client = Client::query()
            ->where('name', $validator->validated()['name'])
            ->where('phone', $validator->validated()['phone'])
            ->where('active', true)
            ->first();

        if (! $client) {
            return response()->json([
                'message' => 'Nome ou telefone inválidos, ou conta inativa.',
            ], 401);
        }

        $token = $client->createToken('delivery')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso.',
            'data' => [
                'token' => $token,
                'client' => $this->clientData($client),
            ],
        ]);
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
