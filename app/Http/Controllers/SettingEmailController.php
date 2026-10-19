<?php

namespace App\Http\Controllers;

use App\Models\SettingEmail;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class SettingEmailController extends Controller
{
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        
        // 'config_smtp' → é o módulo definido no template_modules.php.
        // 'email.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('config_smtp', 'email.visualizar', $settingTheme);

        if ($check !== true) {
            return $check;
        }

        $settingEmail = SettingEmail::first();
        unset($settingEmail->mail_password);

        return view('admin.blades.seetingEmail.form', compact('settingEmail'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        try {
            DB::beginTransaction();
                $email =SettingEmail::create($data);

                Session::flash('success', __('dashboard.response_item_create'));
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {

            DB::rollback();
                Session::flash('error', __('dashboard.response_item_error_create'));
                return redirect()->back();
        }
    }

    public function update(Request $request, SettingEmail $settingEmail)
    {
        $data = $request->all();

        try {
            DB::beginTransaction();
                if ($request->filled('mail_password')) {
                    $data['mail_password'] = $request->mail_password;
                } else {
                    unset($data['mail_password']);
                }
                $settingEmail->fill($data)->save();
                Session::flash('success', __('dashboard.response_item_update'));
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
                Session::flash('error', __('dashboard.response_item_error_update'));
                return redirect()->back();
        }
    }

    public function destroy(SettingEmail $settingEmail)
    {
        $settingEmail->delete();
        Session::flash('success', __('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function smtpVerify()
    {
        try {
            $user = Auth::user();
            $emailSettings = SettingEmail::first();

            // Atualizando as configurações do Mail
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

            // Enviando o e-mail de teste
            $teste = Mail::raw(__('blades/configEmail.message_for_email_one') . ' ( '. env('APP_NAME') . ' ) ' .__('blades/configEmail.message_for_email_thwo'), function($msg) use ($emailSettings) {
                $msg->to('waggner.dev@gmail.com')
                    ->subject(__('blades/configEmail.subject_test_conection_smtp'))
                    ->from(isset($emailSettings)?$emailSettings->mail_username:'waggner.447@gmail.com', $emailSettings->mail_from_name ?? 'WHI - Web de Alta inspiração');
            });

            if($teste){
                activity()
                ->causedBy($user)
                ->performedOn($emailSettings)
                ->event('multiple_deleted')
                ->withProperties([
                    'attributes' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'active' => $user->active,
                        'event' => 'test_conection_smtp',
                    ]
                ])
                ->log('test_conection_smtp');
            }

            return Response::json(['status'=> 'success', 'message' => __('blades/configEmail.message_conection_smtp_success')]);
        } catch (Exception $e) {
            return Response::json([
                'status'=> 'error',
                'message' => __('blades/configEmail.message_conection_smtp_error'),
                'details' => $e->getMessage()
            ]);
        }
    }
}
