<div class="card">
    <div class="card-body">

        <h4 class="mt-0 mb-2 font-weight-semibold">Grupos de permissões</h4>

        <p>
            O gerenciamento de grupos de usuários e permissões é fundamental para assegurar que as funcionalidades do sistema estejam acessíveis apenas aos usuários corretos, de acordo com suas responsabilidades e níveis de acesso. No painel, o sistema de permissões é estruturado em grupos <code>(ou roles)</code>, onde cada grupo possui um conjunto de permissões que define claramente o que os membros daquele grupo podem ou não fazer. Dessa forma, é possível gerenciar o acesso de maneira precisa e organizada.

            Para implementar esse controle de acesso, foi utilizado o pacote <code>Spatie Laravel Permission</code>, que oferece uma solução flexível e eficiente para atribuir e gerenciar permissões e papéis no Laravel. Esse pacote facilita a criação de regras de acesso, permitindo associar permissões tanto diretamente aos usuários quanto aos grupos, garantindo que cada usuário tenha os privilégios adequados às suas funções no sistema.        </p>

        <h4 class="mt-0 mb-2 font-weight-semibold">O que é o Spatie Laravel Permission?</h4>

        <p>
            O <code>Spatie Laravel Permission</code> é um pacote amplamente utilizado no framework Laravel para gerenciar papéis (roles) e permissões de forma simples e eficiente. Ele permite que você atribua permissões diretamente a usuários, ou associe permissões a papéis que, por sua vez, podem ser atribuídos aos usuários. Esse sistema de controle de acesso é útil para garantir que diferentes usuários possam executar ou visualizar apenas as ações e recursos autorizados para seu perfil.
        </p>
        <p>

            <strong>Conheça o nosso trabalho!</strong> Acesse o nosso site em <a href="https://whi.dev.br" target="_blank">https://whi.dev.br</a> e descubra tudo o que podemos oferecer. Se preferir, entre em contato conosco pelo WhatsApp para mais informações.
        </p>
        
    </div>
</div>
<div class="card">
    <div class="card-body">
    
        <h3 class="mt-0 mb-3 font-weight-semibold">Scopes - <span class="font-12">( <code>SuperAdminScope</code> )</span></h3>
        <h4 class="mt-0 mb-2 font-weight-semibold">Estrutura</h4>
        <pre>
    
├── app
│   └── models
│   │   └── scopes
│   │   │   └── superAdminScope.php
                    
        </pre>
        <p>
            Aqui é definido um scopo global do usuário Super, com base no campo roles.id, excluindo as entradas onde o valor de id é igual a 1
        </p>

        <pre>
    
class SuperAdminScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('roles.id', '<>', 1);
    }
}
            
        </pre>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h3 class="mt-0 mb-3 font-weight-semibold">Model - <span class="font-12">( <code>Permission</code> )</span></h3>
        <h4 class="mt-0 mb-2 font-weight-semibold">Estrutura</h4>
        <pre>
    
├── app
│   └── models
│   │   └── permission.php

                
            </pre>
        <p>
            A classe Permission estende a classe original \Spatie\Permission\Models\Permission, que faz parte do pacote Spatie Laravel Permission. Essa classe personalizada foi criada para adicionar algumas funcionalidades específicas e customizadas, como o uso de traits adicionais e métodos para manipular o nome das permissões. 
        </p>

        <pre>
class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, HasRoles, LogsActivity;

    public function name()
    {
        return substr($this->name,strpos($this->name,'.')+1);
    }

    public function index()
    {
        $value = explode('.',$this->name);
        return $value[0];
    }
}
        </pre>
        <h3 class="mt-0 mb-3 font-weight-semibold">Uso - <span class="font-12">( <code>form.blade.php</code> )</span></h3>
        <h4 class="mt-0 mb-2 font-weight-semibold">Estrutura</h4>

        <pre>
├── resource
│   └── views
│   │   └── admin
│   │   │   └── blades
│   │   │   │   └── group
│   │   │   │   │   └── form.blade.php
│   │   │   │   │   │
        </pre>
        
        <ul>
            <li>
                <p>Na blade <code>form.blade.php</code> renderiza uma lista de permissões com checkboxes, organizadas por categorias (indicadas pelo método index() da permissão).</p>
            </li>
                <h5 class="mt-0 mb-2 font-weight-bold">Resumo do que o código faz:</h5>
                <ul>
                    <li><strong>Variáveis Iniciais:</strong> Define uma variável <code>$last_index</code> para rastrear a última categoria (índice) de permissões.</li>
                    <li><strong>Loop nas Permissões:</strong> Percorre a coleção de permissões (<code>$permissions</code>).
                        <ul>
                            <li>Se a permissão atual tiver um índice (<code>$permission->index()</code>) diferente do último renderizado, ele:
                                <ul>
                                    <li>Fecha a lista anterior (<code>&lt;/ul&gt;</code>) se necessário.</li>
                                    <li>Inicia uma nova categoria com o índice da permissão como título (em negrito) e cria uma nova lista não ordenada.</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><strong>Verificação de Permissões:</strong> Dentro de cada categoria, ele verifica se o usuário autenticado tem certos papéis ou permissões.
                        <ul>
                            <li>Se o usuário for "Super" ou tiver permissões especiais (<code>usuario.tornar usuario master</code>, <code>grupo.visualizar</code>, <code>grupo.criar</code>), ele renderiza um checkbox associado à permissão atual.</li>
                            <li>Alternativamente, se o usuário apenas tiver as permissões <code>grupo.visualizar</code> ou <code>grupo.editar</code>, renderiza um checkbox da mesma maneira.</li>
                        </ul>
                    </li>
                    <li><strong>Checkboxes:</strong> Cada permissão é exibida como um checkbox, marcado (<code>checked</code>) se o grupo atual tiver essa permissão. O valor do checkbox é o nome da permissão.</li>
                    <li><strong>Atualização do Índice:</strong> Ao final de cada iteração, o valor de <code>$last_index</code> é atualizado para o índice da permissão atual.</li>
                </ul>
                
            </li>
        </ul>

        <div class="image-code" style="background-image: url('{{ asset('build/admin/images/code.png') }}')">
            {{-- <img src="{{asset('build/admin/images/code.png')}}" alt=""> --}}
        </div>
    </div>
</div>

<style>
    .image-code{
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 555px;
        width: 100%;
    }
</style>