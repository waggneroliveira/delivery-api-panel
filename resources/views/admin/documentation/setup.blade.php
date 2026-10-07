<div class="card">
    <div class="card-body">

        <h4 class="mt-0 mb-2 font-weight-bold">Setup</h4>

        <div class="alert alert-info" role="alert">
            <p class="mb-0">
                <strong>Note:</strong> Essa versão está ajustada para o Laravel 11 e mantém a estrutura original com uma linguagem adequada ao contexto de desenvolvimento no framework.
            </p>
        </div>

        <p class="mt-3">Para instalar e executar o projeto do painel gerenciador de conteúdo, é necessário garantir que o ambiente de desenvolvimento atenda aos seguintes requisitos:</p>

        <h4 class="mt-4">Pré-requisitos</h4>

        <p>Siga as etapas abaixo para instalar e configurar todos os pré-requisitos:</p>

        <ul>
            <li>
                <h5>Node.js e npm</h5>
                <p class="mb-2">
                    Necessários para o gerenciamento de pacotes JavaScript e a compilação de assets, como arquivos CSS e JavaScript.
                    Se você ainda não tem o Node.js instalado,
                    você pode obtê-lo baixando o instalador do pacote no
                    site oficial. Baixe a versão estável do Node.js
                    (LTS).</p><a href="https://nodejs.org/" target="_blank">Baixar
                    Node.js</a>
            </li>
            <li class="pt-2">
                <h5>PHP 8.1 ou superior</h5>
                <p>O projeto requer uma versão recente do PHP para garantir compatibilidade com as novas funcionalidades e segurança.</p>
            </li>
            <li class="pt-2">
                <h5>Extensões PHP</h5>
                <p>Inicialmente, são necessárias as extensões padrão. Caso sejam exigidas novas extensões no futuro, a documentação será atualizada para refletir essas mudanças.</p>
            </li>
            <li>
                <h5>Composer</h5>
                <p>O gerenciador de dependências PHP é essencial para instalar as bibliotecas necessárias do projeto.</p>
            </li>
            <li>
                <h5>Git</h5>
                <p>
                    Certifique-se de ter o Git instalado e configurado corretamente no seu ambiente de desenvolvimento, pois utilizamos controle de versão para gerenciar o código do projeto. 
                    <a href="https://git-scm.com/"
                        target="_blank">Git</a> 
                </p>
            </li>
            <li>
                <h5>Banco de Dados</h5>
                <p>
                    Certifique-se de que o MySQL esteja instalado e configurado corretamente para o seu projeto em Laravel.
                </p>
            </li>
            <li>
                <h5>Servidor Web</h5>
                <p>
                    Você precisará de um servidor web, como Apache ou Nginx, devidamente configurado para hospedar sua aplicação Laravel. Essa configuração é essencial para garantir que sua aplicação funcione corretamente e possa ser acessada pelos usuários. 
                    Sugiro a utilização do XAMPP, WAMP ou Laragon para configurar um servidor web para seus projetos em Laravel. Essas ferramentas facilitam a instalação e configuração do Apache, MySQL e PHP em um ambiente local, tornando o desenvolvimento mais simples e eficiente. 
                </p>
            </li>
        </ul>
        <h4 class="mt-4">Instalação local</h4>
        <p>
            Abra seu terminal, vá até sua pasta e digite o comando <code>npm install</code>. Isso instalaria todas as dependências necessárias na pasta <code>node_modules</code>.
        </p>
        <p class="mt-1">Você pode executar os seguintes comandos para executar o projeto localmente ou compilar para uso em produção:</p>
        <table class="table table-bordered m-0">
            <thead>
                <tr>
                    <th style="width:20%"><i class="ti-file"></i> Comando</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>composer install</code></td>
                    <td>É utilizado para instalar as dependências de um projeto PHP que utiliza o Composer como gerenciador de pacotes. Este comando é fundamental para garantir que todas as bibliotecas necessárias estejam disponíveis para o funcionamento correto da aplicação.
                    </td>
                </tr>
                <tr>
                    <td><code>composer post-update-cmd</code></td>
                    <td>Permite que você defina scripts que serão executados automaticamente após o comando composer update.
                    </td>
                </tr>
                <tr>
                    <td><code>composer post-root-package-install</code></td>
                    <td>Gera o arqvuio env.
                    </td>
                </tr>
                <tr>
                    <td><code>composer post-create-project-cmd</code></td>
                    <td>Gera a key generate do seu projeto. 
                    </td>
                </tr>
                <tr>
                    <td><code>npm install</code></td>
                    <td>Instala os pacotes e dependências do projeto.
                    </td>
                </tr>
            </tbody>
        </table>
        <h4 class="mt-4">Instalação no servidor</h4>
        <table class="table table-bordered m-0">
            <thead>
                <tr>
                    <th style="width:20%"><i class="ti-file"></i> Comando</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php artisan composer.phar install</code></td>
                    <td>É utilizado para instalar as dependências de um projeto PHP que utiliza o Composer como gerenciador de pacotes. Este comando é fundamental para garantir que todas as bibliotecas necessárias estejam disponíveis para o funcionamento correto da aplicação.
                    </td>
                </tr>
                <tr>
                    <td><code>php artisan composer.phar post-update-cmd</code></td>
                    <td>Permite que você defina scripts que serão executados automaticamente após o comando composer update.
                    </td>
                </tr>
                <tr>
                    <td><code>php artisan composer.phar post-root-package-install</code></td>
                    <td>Gera o arqvuio env.
                    </td>
                </tr>
                <tr>
                    <td><code>php artisan composer.phar post-create-project-cmd</code></td>
                    <td>Gera a key generate do seu projeto. 
                    </td>
                </tr>
                <tr>
                    <td><code>php artisan storage:link</code></td>
                    <td>Cria um link simbólico no diretório public do seu aplicativo Laravel, apontando para o diretório de armazenamento (storage/app/public).
                    </td>
                </tr>
                <tr>
                    <td><code>ln -s nome_da_pasta/public nome_do_atalho</code></td>
                    <td>Cria um atalho com o link simbólico no diretório public do seu aplicativo Laravel, de modo que ao acessa a url o mesmo não precise digitar o caminho absoluto.
                        <br><strong>OBS:</strong> Sugestão de padrão para o projeto laravel nome_da_pasta_git
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="mt-1">
            Caso o servidor não tenha o composer, você pode baixa-lo via <code>SSH</code> em <a href="https://imasters.com.br/back-end/instalando-o-composer-php-via-ssh-para-gerenciar-dependencias-do-seu-app-em-nuvem" target="_balnk">Composer via ssh</a> e rodar o comando <code>curl -sS https://getcomposer.org/installer | php</code>.
        </p>
    </div>
</div>