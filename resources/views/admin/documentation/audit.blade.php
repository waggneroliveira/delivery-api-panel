<div>
    <div class="card">
            <div class="card-body">

                <h4 class="mt-0 mb-2 font-weight-semibold">Sistema de auditoria</h4>

                <p>
                    O sistema de auditoria é utilizado para registrar e monitorar atividades dentro do painel gerenciador de conteúdo. O objetivo é fornecer um histórico detalhado das ações realizadas por usuários ou processos, permitindo rastrear quem fez o quê, quando e onde, o que pode ser essencial para segurança, conformidade regulatória e diagnóstico de problemas. O pacote utilizado para desempenhar esta funcção foi o <code>Spatie Laravel Activitylog</code>.
                </p>
                
                <h4 class="mt-0 mb-2 font-weight-semibold">O que é o Spatie Laravel Activitylog?</h4>

                <p>
                    O <code>Spatie Laravel Activitylog</code> é um pacote open-source para Laravel que facilita a implementação de logs de atividades. Ele permite registrar eventos que ocorrem na aplicação, como criação, atualização, exclusão de registros, logins e logouts, ou até mesmo atividades personalizadas que o desenvolvedor deseja monitorar.
                </p>
                <p>

                    <strong>Conheça o nosso trabalho!</strong> Acesse o nosso site em <a href="https://whi.dev.br" target="_blank">https://whi.dev.br</a> e descubra tudo o que podemos oferecer. Se preferir, entre em contato conosco pelo WhatsApp para mais informações.
                </p>
                
            </div>
    </div>
    <div class="card m-b-30">
        <div class="card-body">

            <h3 class="mt-0 mb-3 font-weight-semibold">Service - <span class="font-12">( <code>ActivityLogService</code> )</span></h3>
            <h4 class="mt-0 mb-2 font-weight-semibold">Estrutura</h4>

            <pre>

├── app
│    └── services
│    │   └── activityLogService.php
                
            </pre>
            <p>
                Esse service define uma classe chamada <code>ActivityLogService</code> que é responsável por identificar e retornar os atributos "logáveis" de um modelo <code>(Model)</code>, ou seja, aqueles atributos que podem ser registrados em um log de atividades, excluindo atributos sensíveis ou irrelevantes, como <code>password</code>, <code>created_at</code> e <code>updated_at</code>.
            </p>
            
            <pre>
class ActivityLogService
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getLoggableAttributes(): array
    {
        $attributes = $this->model->getAttributes();

        return array_filter(array_keys($attributes), function ($key) {
            return !in_array($key, ['password', 'created_at', 'updated_at']);
        });
    }
}
            </pre>

            <div class="mt-3">
                <h5 class="mt-0 mb-2 font-weight-bold">Observação</h5>
                <ul>
                    <li>
                        <p>
                            Para que a auditoria funcione da forma correta é necessário utitlizar a função <code>getActivitylogOptions</code> em cada <code>Model</code>, com seus respectivos imports.
                        </p>
                    </li>
                        <h5 class="mt-0 mb-2 font-weight-bold">Imports</h5>
                        <ul>
                            <li>
                                <code>use Spatie\Activitylog\LogOptions</code>
                            </li>
                            <li>
                                <code>use App\Services\ActivityLogService</code>
                            </li>
                            <li>
                                <code>use Spatie\Activitylog\Traits\LogsActivity</code>
                            </li>
                        </ul>
                    </li>
                </ul>
                <pre>
class User extends Authenticatable
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}
                </pre>
            </div>
        </div>
    </div>
    <div class="card m-b-30">
        <div class="card-body">

            <h3 class="mt-0 mb-3 font-weight-semibold">Model - <span class="font-12">( <code>AuditActivity</code> )</span></h3>
            <h4 class="mt-0 mb-2 font-weight-semibold">Estrutura</h4>
            <pre>

├── app
│    └── models
│    │   └── audiActivity.php
                
            </pre>
            <p>
                Nessa model tem a função estática <code>getModelName($subjectType)</code> que recebe como parâmetro o tipo de um modelo ou entidade <strong>(como User, Role, SettingEmail)</strong> e, com base nesse tipo, retorna uma tradução de uma string que representa o nome desse modelo. A tradução é feita utilizando o sistema de localização do Laravel, permitindo que o nome do modelo seja exibido no idioma apropriado.

                Essa função está sendo utilizada na auditoria e/ou logs de atividades <strong>(Spatie Activitylog)</strong>, onde diferentes tipos de objetos precisam ser apresentados ao usuário de forma compreensível e localizada.
            </p>
   
            <pre>

public static function getModelName($subjectType)
{
    switch ($subjectType) { 
    
        case User::class:
            return __('blades/audit.users');
        case Role::class:
            return __('blades/audit.roles');
        case SettingEmail::class:
            return __('blades/audit.setting_email');
        default:
            return __('blades/audit.system');

    }
}
            </pre>
        </div>
    </div>
</div>
