<?php

namespace App\Http\Controllers\Auth;

use App\Models\SettingEmail;
use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;

class PasswordEmailClientController extends Controller
{
    public function passwordEmail(Request $request)
    {
        try {
            $validatedData = $request->validate(['email' => 'required|email']);
            $email = $validatedData['email'];

            $emailSettings = SettingEmail::first(); 

            Config::set([
                'mail.default' => $emailSettings->mail_mailer ?? 'smtp',
                'mail.mailers.smtp.transport' => $emailSettings->mail_mailer ?? 'smtp',
                'mail.mailers.smtp.host' => $emailSettings->mail_host ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port' => $emailSettings->mail_port ?? 465,
                'mail.mailers.smtp.encryption' => $emailSettings->mail_encryption ?? 'ssl',
                'mail.mailers.smtp.username' => $emailSettings->mail_username ?? 'waggner.447@gmail.com',
                'mail.mailers.smtp.password' => $emailSettings->mail_password ?? 'aggd cvvg ljkp gxli',
                'mail.from.address' => $emailSettings->mail_from_address ?? 'waggner.447@gmail.com',
                'mail.from.name' => $emailSettings->mail_from_name ?? 'WHI - Web de Alta inspiração',
            ]);
            
            
            $emailService = new EmailService();
            $emailService->configureAndSend($emailSettings, $request->only('email'));
            
            $status = Password::broker('clients')->sendResetLink($request->only('email'));
  
            if (Password::RESET_LINK_SENT) {
                return redirect()->route('send-success-client')->with(['status' => __($status), 'email' => $email]);
            } else {
                return back()->withErrors(['email' => 'Por favor, aguarde antes de tentar novamente.']);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Erro ao enviar o link de redefinição de senha. Por favor, verifique as configurações SMTP no painel de gerenciamento e tente novamente']);
        }
    }

    public function showSuccess(Request $request)
    {
        $email = $request->session()->get('email');
    
        return view('emails.send-success-client', compact('email'));
    }
}
