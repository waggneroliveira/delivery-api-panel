<?php

namespace App\Services;

class ActivityLogService
{
    protected $model;

    protected const IGNORED_ATTRIBUTES = [
        'created_at',
        'deleted_at',
        'password',
        'remember_token',
        'updated_at',
    ];

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getLoggableAttributes(): array
    {
        $table = $this->model->getTable();
        $columns = $this->model->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($table);

        return array_values(array_filter(
            $columns,
            fn (string $attribute) => ! in_array($attribute, self::IGNORED_ATTRIBUTES, true)
        ));
    }
}
