<?php

namespace App\Services;

use Exception;
use App\Models\SettingEmail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;

class EmailService {
    public function configureAndSend($emailSettings) {
        if (!$emailSettings) {
            throw new \InvalidArgumentException("Configurações de e-mail não encontradas.");
        }

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

    }    
}

