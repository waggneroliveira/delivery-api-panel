<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class ModulePermissionService
{
    /**
     * Verifica se o usuário pode acessar determinado módulo/permissão.
     */
    public function checkPermission( string $module, string $permission, $settingTheme) {
        $user = Auth::user();

        if (!$user) {
            return view('admin.error.403', compact('settingTheme'));
        }

        /*
        |--------------------------------------------------------------------------
        | Super / Master
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('Super') ||
            $user->can('usuario.tornar usuario master')
        ) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Verifica se o módulo existe no template atual
        |--------------------------------------------------------------------------
        */

        if (!$this->moduleExists($module)) {
            return view('admin.error.403', compact('settingTheme'));
        }

        /*
        |--------------------------------------------------------------------------
        | Verifica se a permissão pertence ao módulo
        |--------------------------------------------------------------------------
        */

        if (!$this->permissionBelongsToModule($module, $permission)) {
            return view('admin.error.403', compact('settingTheme'));
        }

        /*
        |--------------------------------------------------------------------------
        | Verifica se o usuário possui a permissão
        |--------------------------------------------------------------------------
        */

        if (!$user->hasPermissionTo($permission)) {
            return view('admin.error.403', compact('settingTheme'));
        }

        return true;
    }


    /**
     * Verifica se o módulo existe no template atual.
     */
    public function moduleExists(string $module): bool
    {
        // Pegar o template atual.
        $themeManager = app(\App\Services\ThemeManager::class);

        $themeData = $themeManager->theme();

        $template = $themeData->slug;

        $templateModules = config("template_modules.{$template}", []);

        $modules = collect($templateModules)
            ->except('limits')
            ->flatten()
            ->unique();

        return $modules->contains($module);
    }


    /**
     * Verifica se a permissão pertence ao módulo.
     */
    public function permissionBelongsToModule(string $module, string $permission): bool {
        $permissionConfig = config("module_permissions.{$module}");

        if (!$permissionConfig) {
            return false;
        }

        $permissionPrefix = $permissionConfig['permission'];

        /*
        |--------------------------------------------------------------------------
        | Verifica se a permissão pertence ao módulo
        |--------------------------------------------------------------------------
        */

        if (!str_starts_with($permission, $permissionPrefix . '.')) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Verifica se a ação realmente está cadastrada no módulo
        |--------------------------------------------------------------------------
        */

        $action = substr(
            $permission,
            strlen($permissionPrefix) + 1
        );

        return in_array(
            $action,
            $permissionConfig['actions'],
            true
        );
    }
}