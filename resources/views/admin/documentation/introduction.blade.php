
@extends('admin.core.admin')
@section('content')
<!-- Start Content-->
<div class="container-fluid mt-4">

    <div class="page-wrapper row">

        <!-- end left-sidebar-->
        @include('admin.documentation.navbar')

        <div id="introduction" class="page-content col-10">
            <div class="card">
                    <div class="card-body">

                        <h4 class="mt-0 mb-2 font-weight-semibold">Introdução</h4>

                        <p>
                            <strong>O Painel de Gerenciamento de Conteúdo</strong> é uma solução robusta e eficiente, desenvolvida com o framework <strong>Laravel</strong>, projetada para simplificar a administração e organização de conteúdo em suas aplicações. Com um sistema de permissões baseado em grupos de usuários, você pode gerenciar o acesso de forma segura, garantindo que apenas usuários autorizados tenham acesso às funcionalidades específicas.                        </p>
                        
                        <p>
                            O mesmo também conta com um sistema de auditoria que registra todas as ações realizadas, proporcionando transparência e segurança nas operações. Isso é fundamental para manter o controle sobre alterações e acessos, permitindo uma gestão mais eficaz. Além disso, o sistema possui uma configuração SMTP dinâmica, que facilita a integração com serviços de e-mail, garantindo que suas comunicações sejam enviadas de maneira eficiente e confiável.
                        </p>
                        
                        <p>
                            O painel oferece suporte a três idiomas: português, inglês e espanhol, permitindo que os usuários trabalhem em seu idioma preferido e tornando-o acessível para um público mais amplo. Para personalizar a experiência do usuário, a configuração estilizada de temas permite que você ajuste a aparência do painel de acordo com suas preferências, criando uma interface atraente e intuitiva.
                        </p>
                        
                        <p>
                            Por fim, um sistema de notificações integrado mantém os usuários informados sobre eventos importantes e atualizações, garantindo que todos estejam sempre atualizados e engajados. Com todas essas funcionalidades, o Painel de Gerenciamento de Conteúdo se torna uma ferramenta indispensável para a administração eficaz de seus recursos digitais.
                        </p>
                        
                        <p>
                            <strong>Conheça o nosso trabalho!</strong> Acesse o nosso site em <a href="https://whi.dev.br" target="_blank">https://whi.dev.br</a> e descubra tudo o que podemos oferecer. Se preferir, entre em contato conosco pelo WhatsApp para mais informações.
                        </p>
                        
                    </div>
            </div>
            <div class="card m-b-30">
                <div class="card-body">

                    <h4 class="mt-0 mb-2 font-weight-semibold">Estrutura</h4>

                    <p>
                        Esse é modelo base da estrutura do projeto laravel
                    </p>

                    <pre>

├── app
├── bootstrap
├── config
├── database
├── docs
├── lang
├── node_modules
├── public
├── resources
├── routes
├── storage
├── tests
├── vendor
├── .editorconfig
├── .env
├── .env.example
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package-lock.json
├── package.json
├── phpunit.xml
├── postcss.config.js
├── README.md
├── tailwind.config.js.old
├── vite.config.js
└── vite.config.js.timestamp-xxxxxxxxxxxxxxxxxxxxxxxxxxxx
                                
                    </pre>

                </div>
            </div>
            <div class="card">
                <div class="card-body">


                            <h4 class="mt-0 mb-2 font-weight-semibold">Plugins utilizados</h4>
                            <p>
                                Abaixo estão alguns dos plugins utilizados na construção do painel, acompanhados de links para a documentação oficial de cada um.
                            </p>

                            <div class="table-responsive">
                                <table class="table table-sm mb-0 font-14">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-semibold">Plugins</th>
                                            <th class="font-weight-semibold">Url</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bootstrap</td>
                                            <td><a href="http://getbootstrap.com/" target="_blank">http://getbootstrap.com/</a></td>
                                        </tr>
                                        <tr>
                                            <td>jQuery</td>
                                            <td><a href="https://jquery.com/" target="_blank">https://jquery.com/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Animate</td>
                                            <td><a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Bootstrap-colorpicker</td>
                                            <td><a href="https://farbelous.io/bootstrap-colorpicker/" target="_blank">https://farbelous.io/bootstrap-colorpicker/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Bootstrap-select</td>
                                            <td><a href="https://developer.snapappointments.com/bootstrap-select/" target="_blank">https://developer.snapappointments.com/bootstrap-select/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Bootstrap-table</td>
                                            <td><a href="https://github.com/wenzhixin/bootstrap-table" target="_blank">https://github.com/wenzhixin/bootstrap-table</a></td>
                                        </tr>
                                        <tr>
                                            <td>Clockpicker</td>
                                            <td><a href="http://weareoutman.github.io/clockpicker/" target="_blank">http://weareoutman.github.io/clockpicker/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Dropify</td>
                                            <td><a href="http://jeremyfagis.github.io/dropify/" target="_blank">http://jeremyfagis.github.io/dropify/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Dropzone</td>
                                            <td><a href="https://www.dropzonejs.com/" target="_blank">https://www.dropzonejs.com/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Jquery-sparkline</td>
                                            <td><a href="https://omnipotent.net/jquery.sparkline/#s-about" target="_blank">https://omnipotent.net/jquery.sparkline/#s-about</a></td>
                                        </tr>
                                        <tr>
                                            <td>Jquery-vectormap</td>
                                            <td><a href="http://jvectormap.com/" target="_blank">http://jvectormap.com/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Select2</td>
                                            <td><a href="https://select2.org/" target="_blank">https://select2.org/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Sweetalert2</td>
                                            <td><a href="https://sweetalert2.github.io/" target="_blank">https://sweetalert2.github.io/</a></td>
                                        </tr>
                                        <tr>
                                            <td>toastr</td>
                                            <td><a href="https://github.com/CodeSeven/toastr" target="_blank">https://github.com/CodeSeven/toastr</a></td>
                                        </tr>
                                        <tr>
                                            <td>Bootstrap Datepicker</td>
                                            <td><a href="https://uxsolutions.github.io/bootstrap-datepicker/" target="_blank">https://uxsolutions.github.io/bootstrap-datepicker/</a></td>
                                        </tr>
                                        <tr>
                                            <td>Sortable JS</td>
                                            <td><a href="https://github.com/SortableJS/Sortable" target="_blank">https://github.com/SortableJS/Sortable</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
        </div>

        <div id="setup" class="page-content col-10">
            @include('admin.documentation.setup')
        </div>
        <div id="audit" class="page-content col-10">
            @include('admin.documentation.audit')
        </div>
        <div id="group-permission" class="page-content col-10">
            @include('admin.documentation.groupAndPermission')
        </div>
        <div id="customization" class="page-content col-10">
            @include('admin.documentation.customization')
        </div>
    </div>
    <!-- end page-wrapper-->
</div>
@endsection