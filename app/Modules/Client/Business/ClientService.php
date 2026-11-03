<?php

namespace App\Modules\Client\Business;

use App\Models\Client;
use App\Modules\Client\Contracts\ClientRepositoryInterface;
use App\Modules\Client\DTO\ClientData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class ClientService
{
    protected string $pathUpload = 'admin/uploads/images/perfil/';

    public function __construct(protected ClientRepositoryInterface $repository)
    {
    }

    public function list()
    {
        return $this->repository->all();
    }

    public function create(ClientData $data, ?UploadedFile $imageFile = null): Client
    {
        $payload = $data->toArray();

        if ($data->password !== null) {
            $payload['password'] = Hash::make($data->password);
        }

        if ($imageFile) {
            $payload['path_image'] = $this->storeProfileImage($imageFile);
        }

        return $this->repository->create($payload);
    }

    public function update(Client $client, ClientData $data, ?UploadedFile $imageFile = null): Client
    {
        $payload = $data->toArray();

        if ($data->deletePathImage) {
            $this->deleteStoredImage($client->path_image);
            $payload['path_image'] = null;
        }

        if ($imageFile) {
            $this->deleteStoredImage($client->path_image);
            $payload['path_image'] = $this->storeProfileImage($imageFile);
        }

        if (isset($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        }

        return $this->repository->update($client, $payload);
    }

    public function delete(Client $client): bool
    {
        $this->deleteStoredImage($client->path_image);

        return $this->repository->delete($client);
    }

    protected function storeProfileImage(UploadedFile $file): string
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
        $mime = $file->getMimeType();

        Storage::disk('public')->makeDirectory($this->pathUpload);

        if ($mime === 'image/svg+xml') {
            $file->storeAs($this->pathUpload, $filename, 'public');
        } else {
            $manager = new ImageManager(new ImagickDriver());
            $image = $manager->read($file)
                ->resize(null, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toWebp(quality: 95)
                ->toString();

            Storage::disk('public')->put($this->pathUpload . $filename, $image);
        }

        return 'storage/' . $this->pathUpload . $filename;
    }

    protected function deleteStoredImage(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $storagePath = str_replace('storage/', '', $path);
        Storage::disk('public')->delete($storagePath);
    }
}
