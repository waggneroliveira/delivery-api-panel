<?php

namespace App\Modules\Client\Data;

use App\Models\Client;
use App\Modules\Client\Contracts\ClientRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentClientRepository implements ClientRepositoryInterface
{
    public function all(): Collection
    {
        return Client::query()
            ->orderByDesc('created_at')
            ->get();
    }

    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function update(Client $client, array $data): Client
    {
        $client->update($data);

        return $client->fresh();
    }

    public function delete(Client $client): bool
    {
        return $client->delete();
    }
}
