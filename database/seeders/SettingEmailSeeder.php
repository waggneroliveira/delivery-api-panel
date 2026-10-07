<?php

namespace Database\Seeders;

use App\Models\SettingEmail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SettingEmail::create([
            'mail_mailer' => 'smtp',
            'mail_host' => 'smtp.gmail.com',
            'mail_port' => 465,
            'mail_username' => 'waggner.447@gmail.com',
            'mail_password' => 'aggd cvvg ljkp gxli',
            'mail_encryption' => 'ssl',
            'mail_from_address' => 'waggner.447@gmail.com',
            'mail_from_name' => 'WHI - Web de Alta inspiração',
        ]);
    }
}
