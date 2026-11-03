<?php

use App\Services\ModulePermissionService;

if (!function_exists('checkPermission')) {

    /**
     * Verifica se o usuário possui acesso ao módulo e à permissão informada.
     *
     * @param string $module
     * @param string $permission
     * @param mixed $settingTheme
     * @return bool|\Illuminate\View\View
     */
    function checkPermission(string $module, string $permission, $settingTheme) {
        return app(ModulePermissionService::class)->checkPermission(
            $module,
            $permission,
            $settingTheme
        );
    }
}