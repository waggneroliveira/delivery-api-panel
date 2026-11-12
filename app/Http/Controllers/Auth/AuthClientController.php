<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthClientController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['active'] = 1;

        if (!Auth::guard('client')->attempt($credentials)) {
            return back()->withErrors([
                'email' => 'E-mail, senha inválidos ou usuário inativo.',
            ])->withInput($request->except('password'));
        }

        $request->session()->regenerate();

        session()->flash('success', 'Login realizado com sucesso!');
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('success', 'Logout realizado com sucesso!');
        return redirect()->back();
    }

}
