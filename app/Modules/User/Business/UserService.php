<?php

namespace App\Modules\User\Business;

use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Requests\RequestStoreUser;
use App\Http\Requests\UserUpdateRequest;
use App\Models\SettingTheme;
use App\Models\User;
use App\Repositories\SettingThemeRepository;
use App\Repositories\UserPermissionRepository;
use App\Repositories\UserRoleRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserService
{
    protected string $pathUpload = 'admin/uploads/images/usuario/';

    public function getIndexData(): array
    {
        /*
        |--------------------------------------------------------------------------
        | Usuário autenticado
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        $users = User::query()
            ->with('roles')
            ->sorting();

        /*
        |--------------------------------------------------------------------------
        | Visualização de usuários
        |--------------------------------------------------------------------------
        |
        | Super:
        |   - Pode visualizar todos os usuários.
        |
        | Master:
        |   - Pode visualizar todos, exceto o Super (ID 1).
        |   - Não precisa possuir as demais permissões.
        |
        | Usuário comum:
        |   - Visualiza somente a si mesmo.
        |   - Pode visualizar outros usuários se possuir a permissão
        |     "usuario.visualizar outros usuarios".
        |
        */

        if ($user->id === 1) {

            // Super pode visualizar todos.
            $users->where('id', '<>', 1);

        } elseif ($user->can('usuario.tornar usuario master')) {

            // Master pode visualizar todos, exceto o Super.
            $users->where('id', '<>', 1);

        } elseif ($user->can('usuario.visualizar outros usuarios')) {

            // Usuário com permissão pode visualizar outros usuários.
            $users->where('id', '<>', 1);

        } else {

            // Usuário comum visualiza somente a si mesmo.
            $users->where('id', $user->id);
        }

        $users = $users->get();

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $roles = (new UserRoleRepository())->userRole($users);

        $otherRoles = $roles['otherRoles'] ?? collect();
        $currentRoles = $roles['currentRoles'] ?? collect();

        /*
        |--------------------------------------------------------------------------
        | Permissões disponíveis
        |--------------------------------------------------------------------------
        */

        $permissions = Permission::join(
                'role_has_permissions',
                'permissions.id',
                'role_has_permissions.permission_id'
            )
            ->groupBy('permissions.name')
            ->select('permissions.name')
            ->get();

        return compact(
            'users',
            'otherRoles',
            'permissions',
            'currentRoles'
        );
    }

    public function store(RequestStoreUser $request): User
    {
        $data = $request->except(['path_image', 'is_super']);
        $helper = new HelperArchive();
        $path_image = null;

        if ($request->hasFile('path_image')) {
            $path_image = $helper->renameArchiveUpload($request, 'path_image');
        }

        DB::beginTransaction();
        if ($path_image) {
            $data['path_image'] = $this->pathUpload . $path_image;
        }
        $data['password'] = Hash::make($request->password);
        $data['active'] = $request->active ? 1 : 0;

        $userExist = User::where('email', $data['email'])->first();
        if ($userExist) {
            Storage::delete($this->pathUpload . $path_image);
            throw new \Exception('Usuário já existe');
        }

        $user = User::create($data);
        DB::table('setting_themes')->insert([
            'user_id' => $user->id,
            'data_bs_theme' => 'dark',
            'data_layout_width' => 'default',
            'data_layout_mode' => 'detached',
            'data_topbar_color' => 'light',
            'data_menu_color' => 'light',
            'data_two_column_color' => 'light',
            'data_menu_icon' => 'default',
            'data_sidenav_size' => 'condensed',
            'created_at' => now(),
        ]);

        if ($path_image) {
            $request->file('path_image')->storeAs($this->pathUpload, $path_image);
        }
        DB::commit();

        return $user;
    }

    public function getEditData(UserPermissionRepository $usersWithPermissionsForEdit, User $user, ThemeManager $themeManager): array
    {
        $userHasPermission = $usersWithPermissionsForEdit->usersWithPermissionsForEdit($user);
        if ($userHasPermission === 'forbidden') {
            return ['forbidden' => view('admin.error.403')];
        }

        $currentRoles = $user->roles;
        $otherRoles = Role::where('id', '!=', 1)->whereNotIn('id', $currentRoles->pluck('id'))->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return compact('user', 'currentRoles', 'otherRoles', 'theme', 'themeData');
    }

    public function update(UserUpdateRequest $request, User $user): User
    {
        $data = $request->except('password', 'path_image', 'is_super');
        $helper = new HelperArchive();
        $roles = $request->input('roles', []);
        $path_image = null;

        if ($request->hasFile('path_image')) {
            $path_image = $helper->renameArchiveUpload($request, 'path_image');
        }

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if ($currentUser->hasRole('Super') && $user->id == 1) {
            $roles[] = 'Super';
        }

        DB::beginTransaction();
        if ($path_image) {
            $data['path_image'] = $this->pathUpload . $path_image;
            if ($user->path_image) {
                Storage::delete($user->path_image);
            }
            $request->file('path_image')->storeAs($this->pathUpload, $path_image);
        }

        if (isset($request->delete_path_image) && !$path_image) {
            if ($user->path_image) {
                Storage::delete($user->path_image);
            }
            $data['path_image'] = null;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $data['active'] = $request->active ? 1 : 0;

        $user->fill($data)->save();
        $user->syncRoles($roles);
        DB::commit();

        return $user;
    }

    public function delete(User $user): void
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('Super') && !$currentUser->can('usuario.tornar usuario master') && !$currentUser->can(['usuario.visualizar', 'usuario.remover'])) {
            throw new \Exception('forbidden');
        }

        Storage::delete($user->path_image ?? '');
        $user->delete();

        $settingTheme = SettingTheme::find($user->id);
        if ($settingTheme) {
            $settingTheme->delete();
        }
    }

    public function destroySelected(Request $request): array
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('Super') && !$currentUser->can('usuario.tornar usuario master') && !$currentUser->can(['usuario.visualizar', 'usuario.remover'])) {
            return ['forbidden' => true];
        }

        foreach ($request->deleteAll as $userId) {
            $user = User::find($userId);
            if ($user) {
                Log::info('Dados do usuário antes da exclusão:', [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'active' => $user->active,
                    'sorting' => $user->sorting,
                    'path_image' => $user->path_image,
                ]);
            }
        }

        $deleted = User::whereIn('id', $request->deleteAll)->delete();

        return ['deleted' => $deleted];
    }

    public function sorting(Request $request): array
    {
        foreach ($request->arrId as $sorting => $id) {
            $user = User::find($id);
            if ($user) {
                $user->sorting = $sorting;
                $user->save();
            }
        }

        return ['status' => 'success'];
    }
}
