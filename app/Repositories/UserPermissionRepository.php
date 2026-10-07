<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPermissionRepository
{
public function filterUsersByPermissions($users)
{
    $user = Auth::user();

    $permissoes = [
        'auditoria.visualizar',
        'email.visualizar',
        'categorias do blog.visualizar',
        'newsletter.visualizar',
        'lead contato.visualizar',
        'contato.visualizar',
        'grupo.visualizar',
        'slides.visualizar',
        'notificacao.visualizar',
        'usuario.visualizar',
    ];

    // Se for Super, vê tudo (menos o próprio Super com id 1)
    if ($user->hasRole('Super')) {
        return $users->where('id', '<>', 1);
    }

    // Se for Master, vê tudo menos o Super
    if ($user->can('usuario.tornar usuario master')) {
        return $users->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'Super');
        })->where('id', '<>', 1);
    }
    // Se não tem nenhuma permissão de visualização listada
    $temPermissao = collect($permissoes)->contains(function ($p) use ($user) {
        return $user->can($p);
    });
    if (!$temPermissao) {
        return 'forbidden';
    }

    // Se pode visualizar outros usuários
    if ($user->can('usuario.visualizar outros usuarios')) {
        return $users->where('id', '<>', 1);
    }

    // Só pode visualizar a si mesmo
    return $users->where('id', $user->id)->where('id', '<>', 1);
}

    public function usersWithPermissionsForEdit(){

        if(!Auth::user()->hasRole('Super') && !Auth::user()->can('usuario.tornar usuario master') && !Auth::user()->can(['usuario.visualizar','usuario.editar'])){
            return 'forbidden';
        }
    }
}
