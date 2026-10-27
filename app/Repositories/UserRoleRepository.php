<?php
namespace App\Repositories;

use Spatie\Permission\Models\Role;

class UserRoleRepository
{
    public function userRole($users)
    {
        $otherRolesBase = Role::where('id', '!=', 1)->get();
        $otherRoles = collect(); 
        $currentRoles = collect(); 
    
        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $currentRoleIds = Role::join('model_has_roles', 'roles.id', 'model_has_roles.role_id')
                    ->join('users', 'model_has_roles.model_id', 'users.id')
                    ->where('users.id', $user->id)
                    ->pluck('roles.id');
    
                $currentRoles = Role::whereIn('id', $currentRoleIds)->get();
                $otherRoles = $otherRolesBase->whereNotIn('id', $currentRoleIds->toArray());

                $user->currentRoles = $currentRoles;
                $user->otherRoles = $otherRoles;
            }
        }
    
        return ['otherRoles' => $otherRoles, 'currentRoles' => $currentRoles];
    }
    
}