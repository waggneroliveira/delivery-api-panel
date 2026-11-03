<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditActivity extends Model
{
    use HasFactory;

    public static function getModelName($subjectType)
    {
        switch ($subjectType) { 
            case About::class:
                return 'Sobre Nós';
            case Agreement::class:
                return 'Convênios';
            case Announcement::class:
                return 'Anuncios';
            case Blog::class:
                return 'Notícias';
            case BlogCategory::class:
                return 'Categoria de notícias';
            case Contact::class:
                return 'Contato';
            case Direction::class:
                return 'Tópico Sobre';
            case Event::class:
                return 'Agenda';
            case FormIndex::class:
                return 'Lead contato - Informações enviadas pelo site (formulário de contato)';
            case Holidays::class:
                return 'Feriados';
            case Newsletter::class:
                return 'Newsletter - E-mail enviado pelo site';
            case PopUp::class:
                return 'Pop-Up';
            case Report::class:
                return 'Sessão Anuncie';
            case Role::class:
                return __('blades/audit.roles');
            case SettingEmail::class:
                return __('blades/audit.setting_email');
            case User::class:
                return __('blades/audit.users');
            case Video::class:
                return 'Vídeos';
            default:
                return __('blades/audit.system');
        }
    }
}
