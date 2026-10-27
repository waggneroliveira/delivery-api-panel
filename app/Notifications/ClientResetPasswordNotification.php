<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ClientResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Redefinição de Senha - Cliente')
            ->view('emails.forgot-password-client', [
                'url' => $this->resetUrl($notifiable)
            ]);
    }

    protected function resetUrl($notifiable)
    {
        return url(route('client.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
