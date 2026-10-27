<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

class AuthController extends Controller
{

    public function authenticate(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        $tenant = Tenant::current();

        /*------------------ Busca o usuário ignorando os Global Scopes -------------------*/
        $user = User::withoutGlobalScopes()
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'E-mail inválido.',
                ])
                ->withInput($request->only('email'));
        }

        /*
        |--------------------------------------------------------------------------
        | Validação de Tenant
        |--------------------------------------------------------------------------
        |
        | ID 1 = Super usuário global.
        |
        */

        if ((int) $user->id !== 1) {

            if (!$tenant) {
                return back()
                    ->withErrors([
                        'email' => 'Não foi possível identificar o site acessado.',
                    ])
                    ->withInput($request->only('email'));
            }

            if (
                !$user->tenant_id ||
                (int) $user->tenant_id !== (int) $tenant->id
            ) {
                return back()
                    ->withErrors([
                        'email' => 'Este usuário não possui acesso a este site.',
                    ])
                    ->withInput($request->only('email'));
            }

            if (!$user->active) {
                return back()
                    ->withErrors([
                        'email' => 'Usuário inativo.',
                    ])
                    ->withInput($request->only('email'));
            }
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'Senha inválida.',
                ])
                ->withInput($request->only('email'));
        }

        Auth::guard('web')->login($user, $remember);

        $request->session()->regenerate();

        if (!Auth::guard('web')->check()) {
            return back()
                ->withErrors([
                    'email' => 'Não foi possível iniciar a sessão.',
                ])
                ->withInput($request->only('email'));
        }

        $userAuthenticate = Auth::guard('web')->user();

        if (!$userAuthenticate->hasRole('Super')) {

            activity()
                ->causedBy($userAuthenticate)
                ->performedOn($userAuthenticate)
                ->event('login')
                ->withProperties([
                    'attributes' => [
                        'id' => $userAuthenticate->id,
                        'name' => $userAuthenticate->name,
                        'email' => $userAuthenticate->email,
                        'active' => $userAuthenticate->active,
                        'path_image' => $userAuthenticate->path_image,
                        'remember_token' => $userAuthenticate->remember_token,
                        'email_verified_at' => $userAuthenticate->email_verified_at,
                        'remember' => $remember,
                        'event' => 'login',
                    ],
                ])
                ->log('login');
        }

        session()->flash(
            'success',
            'Login realizado com sucesso!'
        );

        return redirect()->intended('painel/dashboard');
    } 

    public function logout(Request $request)
    {
        $userAuthenticate = Auth::user();

        if ($userAuthenticate) {

            $user = User::select(
                'id',
                'name',
                'email'
            )->find($userAuthenticate->id);

            if ($user && !$user->hasRole('Super')) {

                activity()
                    ->causedBy($userAuthenticate)
                    ->performedOn($user)
                    ->event('logout')
                    ->withProperties([
                        'attributes' => [
                            'id' => $userAuthenticate->id,
                            'name' => $userAuthenticate->name,
                            'email' => $userAuthenticate->email,
                            'event' => 'logout',
                        ],
                    ])
                    ->log('logout');
            }
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with(
                'success',
                'Logout realizado com sucesso!'
            );
    }
}