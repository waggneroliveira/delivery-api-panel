<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordClientController extends Controller
{
    public function showResetForm($token){
        return view('client.auth.reset-password-client', [
            'token'=>$token
        ]);
    }

    public function processPasswordReset(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('clients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($client, $password) {
                $client->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $client->save();

                event(new PasswordReset($client));

                //Logar automaticamente
                // Auth::guard('client')->login($client); 
            }
        );
        Session::flash('success', 'Senha alterada com sucesso!');
            return $status === Password::PASSWORD_RESET
                        ? redirect()->route('blog')->with('status', __($status))
                        : back()->withErrors(['email' => [__($status)]]);
    }
}
