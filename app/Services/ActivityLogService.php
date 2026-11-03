<?php

namespace App\Services;

class ActivityLogService
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getLoggableAttributes(): array
    {
        // Obtém todos os atributos do modelo
        $attributes = $this->model->getAttributes();

        // Filtra os atributos que você deseja logar
        return array_filter(array_keys($attributes), function ($key) {
            // Exclui propriedades que não devem ser logadas, como 'password'
            return !in_array($key, ['password', 'created_at', 'updated_at']);
        });
    }
}
