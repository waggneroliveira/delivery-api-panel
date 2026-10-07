<?php

namespace App\Models\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Spatie\Multitenancy\Models\Tenant;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tenant = Tenant::current();

        if (!$tenant) {
            return;
        }

        $table = $model->getTable();

        /*
        |--------------------------------------------------------------------------
        | Usuários
        |--------------------------------------------------------------------------
        |
        | O usuário ID 1 é o Super usuário global.
        |
        | Ele não possui tenant_id e pode ser recuperado
        | independentemente do tenant atual.
        |
        */

        if ($model instanceof User) {

            $builder->where(function (Builder $query) use ($table, $tenant) {

                $query->where(
                    $table . '.tenant_id',
                    $tenant->id
                );

                $query->orWhere(
                    $table . '.id',
                    1
                );
            });

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Demais Models
        |--------------------------------------------------------------------------
        |
        | Todos os demais registros pertencem obrigatoriamente
        | ao tenant atual.
        |
        */

        $builder->where(
            $table . '.tenant_id',
            $tenant->id
        );
    }
}