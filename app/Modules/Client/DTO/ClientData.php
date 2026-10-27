<?php

namespace App\Modules\Client\DTO;

class ClientData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public bool $active = true,
        public ?string $pathImage = null,
        public bool $deletePathImage = false,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) ($data['name'] ?? ''),
            email: (string) ($data['email'] ?? ''),
            password: $data['password'] ?? null,
            active: (bool) ($data['active'] ?? true),
            pathImage: $data['path_image'] ?? null,
            deletePathImage: (bool) ($data['delete_path_image'] ?? false),
        );
    }

    public function toArray(): array
    {
        $payload = [
            'name' => $this->name,
            'email' => $this->email,
            'active' => $this->active,
        ];

        if ($this->password !== null && $this->password !== '') {
            $payload['password'] = $this->password;
        }

        if ($this->pathImage !== null) {
            $payload['path_image'] = $this->pathImage;
        }

        return $payload;
    }
}
