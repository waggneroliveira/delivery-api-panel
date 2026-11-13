<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity;

class AuditActivity extends Activity
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (self $activity) {
            $causer = $activity->causer;

            if (! $causer instanceof User && $activity->causer_id === Auth::id()) {
                $causer = Auth::user();
            }

            if ($causer instanceof User && $causer->hasRole('Super')) {
                return false;
            }

            return true;
        });
    }

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
            case Client::class:
                return 'Clientes';
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
