<?php

namespace App\Modules\Client\Contracts;

use App\Models\Client;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    public function all(): Collection;

    public function create(array $data): Client;

    public function update(Client $client, array $data): Client;

    public function delete(Client $client): bool;
}
