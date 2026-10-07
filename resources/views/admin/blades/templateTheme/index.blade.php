@extends('admin.core.admin')
@section('content')
<style>
    .btn-group.focus-btn-group{
        display: none;
    }
</style>
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('dashboard.title_dashboard')}}</a></li>
                                <li class="breadcrumb-item active">Templates</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Templates</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-12 d-flex justify-between">
                                    <div class="col-6">
                                        {{-- @if(Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['templateTheme.visualizar', 'templateTheme.remover']))
                                            <button id="btSubmitDelete" data-route="{{route('admin.dashboard.templateTheme.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                        @endif --}}
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        @if (Auth::user()->hasRole('Super'))
                                            {{-- @if (isset($templateTheme) && !$templateTheme)                                            
                                            @endif --}}
                                            <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#templateTheme-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="templateTheme-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="templateTheme modal-dialog modal-dialog-centered" style="max-width:980px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <form action="{{route('admin.dashboard.templateTheme.store')}}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                {{-- @include('admin.blades.templateTheme.form', ['formPrefix' => 'create'])   --}}
                                                                @includeIf("admin.blades.templateTheme.form", ['formPrefix' => 'create'])
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
                                                                    <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</button>
                                                                </div>                                                 
                                                            </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endif
                                    </div>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table-sortable table table-centered table-nowrap table-striped" id="products-datatable">
                                    <thead>                                        
                                        <tr>
                                            <th>Template</th>
                                            <th>Varição</th>
                                            <th>Tipo</th>
                                            <th>{{__('dashboard.status')}}</th>
                                            <th style="width: 85px;">{{__('dashboard.action')}}</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>{{-- data-route="{{route('admin.dashboard.templateTheme.sorting')}}" --}}
                                        @foreach($templateThemes as $templateTheme)                                            
                                            <tr>{{--data-code="{{$templateTheme->id}}"--}}
                                                <td>
                                                    {!!isset($templateTheme->name)?$templateTheme->name:'-'!!}
                                                </td>
                                                <td class="text-start">
                                                    {{$templateTheme->template_variation}}
                                                </td>                                                
                                                <td class="text-start">
                                                    {{$templateTheme->layout_type}}
                                                </td> 
                                                <td>
                                                    @switch($templateTheme->active)
                                                        @case(0) <span class="badge bg-soft text-danger">{{__('dashboard.inactive')}}</span> @break
                                                        @case(1) <span class="badge bg-soft-success text-success">{{__('dashboard.active')}}</span>@break
                                                    @endswitch                                                    
                                                </td>
            
                                                <td class="d-flex gap-lg-1 justify-center" style="padding: 18px 15px 0px 0px;">
                                                    @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['configuracao do tema.visualizar', 'configuracao do tema.editar'])) 
                                                        <button data-bs-toggle="modal" data-bs-target="#templateTheme-edit-{{$templateTheme->id}}" class="tabledit-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                        <div class="modal fade" id="templateTheme-edit-{{$templateTheme->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="templateTheme modal-dialog modal-dialog-centered" style="max-width:980px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_edit')}}</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                    </div>
                                                                    <div class="modal-body p-4">
                                                                        <form action="{{ route('admin.dashboard.templateTheme.update', ['templateTheme' => $templateTheme->id]) }}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            {{-- @include('admin.blades.templateTheme.form', ['formPrefix' => 'edit'])    --}}
                                                                            @includeIf("admin.blades.templateTheme.form", ['formPrefix' => 'edit'])
                                                                            <div class="d-flex justify-content-end gap-2">
                                                                                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
                                                                                <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_save')}}</button>
                                                                            </div>                                                                                                                      
                                                                        </form>                                                                    
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->
                                                    @endif
                                                    @if (Auth::user()->hasRole('Super'))
                                                        <form action="{{route('admin.dashboard.templateTheme.destroy',['templateTheme' => $templateTheme->id])}}" style="width: 30px" method="POST">
                                                            @method('DELETE') @csrf        
                                                            
                                                            <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                                        </form>                                                    
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function initTechnologyField(wrapper) {

            // Evita inicializar o mesmo campo duas vezes
            if (wrapper.dataset.technologyInitialized === 'true') {
                return;
            }

            wrapper.dataset.technologyInitialized = 'true';

            const input = wrapper.querySelector('.technology-input');
            const tagsContainer = wrapper.querySelector('.technology-tags');
            const hiddenInput = wrapper
                .closest('form')
                ?.querySelector('.technology-hidden');

            if (!input || !tagsContainer || !hiddenInput) {
                return;
            }

            let technologies = [];

            /*
            |--------------------------------------------------------------------------
            | Carrega tecnologias existentes
            |--------------------------------------------------------------------------
            */

            if (hiddenInput.value.trim() !== '') {

                technologies = hiddenInput.value
                    .split(',')
                    .map(function (technology) {
                        return technology.trim();
                    })
                    .filter(function (technology) {
                        return technology !== '';
                    });
            }


            /*
            |--------------------------------------------------------------------------
            | Atualiza input hidden
            |--------------------------------------------------------------------------
            */

            function updateHidden() {

                hiddenInput.value = technologies.join(', ');
            }


            /*
            |--------------------------------------------------------------------------
            | Renderiza tags
            |--------------------------------------------------------------------------
            */

            function renderTags() {

                tagsContainer.innerHTML = '';

                technologies.forEach(function (technology, index) {

                    const tag = document.createElement('span');

                    tag.className =
                        'badge rounded-pill d-inline-flex align-items-center gap-2';

                    tag.style.backgroundColor = '#eef4ff';
                    tag.style.color = '#0d6efd';
                    tag.style.padding = '7px 10px';
                    tag.style.fontSize = '13px';


                    const text = document.createElement('span');

                    text.textContent = technology;


                    const remove = document.createElement('button');

                    remove.type = 'button';

                    remove.className = 'technology-remove';

                    remove.innerHTML = '&times;';

                    remove.style.border = '0';
                    remove.style.background = 'transparent';
                    remove.style.color = 'inherit';
                    remove.style.padding = '0';
                    remove.style.margin = '0';
                    remove.style.cursor = 'pointer';
                    remove.style.fontSize = '17px';
                    remove.style.lineHeight = '12px';


                    remove.addEventListener('click', function (event) {

                        event.preventDefault();
                        event.stopPropagation();

                        technologies.splice(index, 1);

                        renderTags();

                        input.focus();
                    });


                    tag.appendChild(text);
                    tag.appendChild(remove);

                    tagsContainer.appendChild(tag);
                });

                updateHidden();
            }


            /*
            |--------------------------------------------------------------------------
            | Adiciona tecnologia
            |--------------------------------------------------------------------------
            */

            function addTechnology(value) {

                value = value.trim();

                if (!value) {
                    return;
                }


                // Evita duplicadas
                const alreadyExists = technologies.some(function (item) {

                    return item.toLowerCase() === value.toLowerCase();

                });


                if (!alreadyExists) {

                    technologies.push(value);

                }


                input.value = '';

                renderTags();

                input.focus();
            }


            /*
            |--------------------------------------------------------------------------
            | Vírgula
            |--------------------------------------------------------------------------
            */

            input.addEventListener('input', function () {

                const value = input.value;

                if (!value.includes(',')) {
                    return;
                }


                const parts = value.split(',');


                // Tudo antes da última vírgula vira tag
                for (let i = 0; i < parts.length - 1; i++) {

                    addTechnology(parts[i]);

                }


                // Mantém o texto depois da última vírgula
                input.value = parts[parts.length - 1];
            });


            /*
            |--------------------------------------------------------------------------
            | Enter
            |--------------------------------------------------------------------------
            */

            input.addEventListener('keydown', function (event) {

                if (event.key === 'Enter') {

                    event.preventDefault();

                    addTechnology(input.value);

                }


                /*
                |--------------------------------------------------------------------------
                | Backspace remove última tag
                |--------------------------------------------------------------------------
                */

                if (
                    event.key === 'Backspace' &&
                    input.value === '' &&
                    technologies.length > 0
                ) {

                    technologies.pop();

                    renderTags();

                }

            });


            /*
            |--------------------------------------------------------------------------
            | Foco no input ao clicar no container
            |--------------------------------------------------------------------------
            */

            wrapper.addEventListener('click', function () {

                input.focus();

            });


            /*
            |--------------------------------------------------------------------------
            | Render inicial
            |--------------------------------------------------------------------------
            */

            renderTags();
        }


        /*
        |--------------------------------------------------------------------------
        | Inicializa todos os campos existentes
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.technology-tags-wrapper')
            .forEach(function (wrapper) {

                initTechnologyField(wrapper);

            });


        /*
        |--------------------------------------------------------------------------
        | IMPORTANTE PARA MODAIS / CONTEÚDO DINÂMICO
        |--------------------------------------------------------------------------
        |
        | Caso o conteúdo do modal seja inserido no DOM depois do
        | DOMContentLoaded, usamos MutationObserver.
        |
        */

        const observer = new MutationObserver(function (mutations) {

            mutations.forEach(function (mutation) {

                mutation.addedNodes.forEach(function (node) {

                    if (node.nodeType !== 1) {
                        return;
                    }


                    // Se o próprio elemento for o wrapper
                    if (
                        node.matches &&
                        node.matches('.technology-tags-wrapper')
                    ) {

                        initTechnologyField(node);

                    }


                    // Procura wrappers dentro do elemento adicionado
                    if (node.querySelectorAll) {

                        node
                            .querySelectorAll('.technology-tags-wrapper')
                            .forEach(function (wrapper) {

                                initTechnologyField(wrapper);

                            });

                    }

                });

            });

        });


        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function initHighlightField(wrapper) {

            // Evita inicializar duas vezes
            if (wrapper.dataset.highlightInitialized === 'true') {
                return;
            }

            wrapper.dataset.highlightInitialized = 'true';

            const input = wrapper.querySelector('.highlight-input');

            const tagsContainer = wrapper.querySelector('.highlight-tags');

            const hiddenInput = wrapper
                .closest('form')
                ?.querySelector('.highlight-hidden');


            if (!input || !tagsContainer || !hiddenInput) {
                return;
            }


            let highlights = [];


            /*
            |--------------------------------------------------------------------------
            | Carrega os destaques existentes
            |--------------------------------------------------------------------------
            */

            if (hiddenInput.value.trim() !== '') {

                highlights = hiddenInput.value
                    .split(',')
                    .map(function (highlight) {
                        return highlight.trim();
                    })
                    .filter(function (highlight) {
                        return highlight !== '';
                    });

            }


            /*
            |--------------------------------------------------------------------------
            | Atualiza o hidden
            |--------------------------------------------------------------------------
            */

            function updateHidden() {

                hiddenInput.value = highlights.join(', ');

            }


            /*
            |--------------------------------------------------------------------------
            | Renderiza as tags
            |--------------------------------------------------------------------------
            */

            function renderTags() {

                tagsContainer.innerHTML = '';


                highlights.forEach(function (highlight, index) {

                    const tag = document.createElement('span');

                    tag.className =
                        'badge rounded-pill d-inline-flex align-items-center gap-2';

                    tag.style.backgroundColor = '#eef4ff';

                    tag.style.color = '#0d6efd';

                    tag.style.padding = '7px 10px';

                    tag.style.fontSize = '13px';


                    /*
                    |--------------------------------------------------------------------------
                    | Texto
                    |--------------------------------------------------------------------------
                    */

                    const text = document.createElement('span');

                    text.textContent = highlight;


                    /*
                    |--------------------------------------------------------------------------
                    | Botão X
                    |--------------------------------------------------------------------------
                    */

                    const remove = document.createElement('button');

                    remove.type = 'button';

                    remove.className = 'highlight-remove';

                    remove.innerHTML = '&times;';

                    remove.title = 'Remover destaque';

                    remove.style.border = '0';

                    remove.style.background = 'transparent';

                    remove.style.color = 'inherit';

                    remove.style.padding = '0';

                    remove.style.margin = '0';

                    remove.style.cursor = 'pointer';

                    remove.style.fontSize = '17px';

                    remove.style.lineHeight = '12px';


                    /*
                    |--------------------------------------------------------------------------
                    | Remove destaque
                    |--------------------------------------------------------------------------
                    */

                    remove.addEventListener('click', function (event) {

                        event.preventDefault();

                        event.stopPropagation();


                        highlights.splice(index, 1);


                        renderTags();

                        input.focus();

                    });


                    tag.appendChild(text);

                    tag.appendChild(remove);


                    tagsContainer.appendChild(tag);

                });


                updateHidden();

            }


            /*
            |--------------------------------------------------------------------------
            | Adiciona destaque
            |--------------------------------------------------------------------------
            */

            function addHighlight(value) {

                value = value.trim();


                if (!value) {
                    return;
                }


                /*
                | Evita duplicados
                */

                const alreadyExists = highlights.some(function (item) {

                    return item.toLowerCase() === value.toLowerCase();

                });


                if (!alreadyExists) {

                    highlights.push(value);

                }


                input.value = '';


                renderTags();

                input.focus();

            }


            /*
            |--------------------------------------------------------------------------
            | Vírgula
            |--------------------------------------------------------------------------
            */

            input.addEventListener('input', function () {

                const value = input.value;


                if (!value.includes(',')) {
                    return;
                }


                const parts = value.split(',');


                /*
                | Tudo antes da última vírgula vira tag
                */

                for (let i = 0; i < parts.length - 1; i++) {

                    addHighlight(parts[i]);

                }


                /*
                | Mantém o que veio depois da última vírgula
                */

                input.value = parts[parts.length - 1];

            });


            /*
            |--------------------------------------------------------------------------
            | Enter
            |--------------------------------------------------------------------------
            */

            input.addEventListener('keydown', function (event) {

                if (event.key === 'Enter') {

                    event.preventDefault();

                    addHighlight(input.value);

                }


                /*
                |--------------------------------------------------------------------------
                | Backspace remove último destaque
                |--------------------------------------------------------------------------
                */

                if (
                    event.key === 'Backspace' &&
                    input.value === '' &&
                    highlights.length > 0
                ) {

                    highlights.pop();

                    renderTags();

                }

            });


            /*
            |--------------------------------------------------------------------------
            | Clicar no container
            |--------------------------------------------------------------------------
            */

            wrapper.addEventListener('click', function () {

                input.focus();

            });


            /*
            |--------------------------------------------------------------------------
            | Render inicial
            |--------------------------------------------------------------------------
            */

            renderTags();

        }


        /*
        |--------------------------------------------------------------------------
        | Inicializa os campos existentes
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.highlight-tags-wrapper')
            .forEach(function (wrapper) {

                initHighlightField(wrapper);

            });


        /*
        |--------------------------------------------------------------------------
        | Suporte para modais carregados dinamicamente
        |--------------------------------------------------------------------------
        */

        const observer = new MutationObserver(function (mutations) {

            mutations.forEach(function (mutation) {

                mutation.addedNodes.forEach(function (node) {

                    if (node.nodeType !== 1) {
                        return;
                    }


                    /*
                    | O próprio elemento
                    */

                    if (
                        node.matches &&
                        node.matches('.highlight-tags-wrapper')
                    ) {

                        initHighlightField(node);

                    }


                    /*
                    | Elementos internos
                    */

                    if (node.querySelectorAll) {

                        node
                            .querySelectorAll('.highlight-tags-wrapper')
                            .forEach(function (wrapper) {

                                initHighlightField(wrapper);

                            });

                    }

                });

            });

        });


        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

    });
</script>

<script>
    function removeTemplatePreview(button) {
        const item = button.closest('[data-preview-item]');

        if (!item) {
            return;
        }

        const deleteInput = item.querySelector('[data-delete-preview]');

        if (!deleteInput) {
            return;
        }

        /*
         * Habilita o input para que ele seja enviado no formulário.
         */
        deleteInput.disabled = false;

        /*
         * Marca visualmente como removido.
         */
        item.classList.add('template-preview-removing');

        /*
         * Evita clicar novamente.
         */
        button.disabled = true;

        /*
         * Opcional: altera o ícone para indicar que está marcado.
         */
        button.innerHTML = '<i class="bi bi-check-lg"></i>';
        button.title = 'Imagem marcada para remoção';
    }
</script>
@endsection
