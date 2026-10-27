@extends('admin.core.admin')
@section('content')
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
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Vantagens</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Vantagens</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 d-flex justify-between">
                                        <div class="col-4">
                                            @if (Auth::user()->hasPermissionTo('vantagens.visualizar') &&
                                            Auth::user()->hasPermissionTo('vantagens.remover') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <button id="btSubmitDelete" data-route="{{route('admin.dashboard.advantage.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                            @endif
                                        </div>
                                        <div class="col-8 d-flex justify-content-end">
                                            @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['vantagens.visualizar', 'vantagens.criar']))

                                                {{-- Vantagens para Pessoas --}}
                                                @if (empty($serviceSection['advantages_persona']))

                                                    <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light"
                                                            data-bs-toggle="modal" data-bs-target="#serviceItem-section-create-persona">
                                                        <i class="mdi mdi-plus-circle me-1"></i> Informações da sessão - Pessoas
                                                    </button>

                                                    <div class="modal fade" id="serviceItem-section-create-persona" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h4 class="modal-title">{{__('dashboard.btn_create')}} - Sessão Pessoas</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>

                                                                <div class="modal-body p-4">
                                                                    <form action="{{ route('admin.dashboard.serviceSection.store') }}" method="POST" enctype="multipart/form-data">
                                                                        @csrf

                                                                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.advantageSection.form", [
                                                                            'textareaId' => 'textarea-create-persona',
                                                                            'serviceSection',
                                                                            'serviceItem',
                                                                            'themeData',
                                                                            'forYou' => 'persona'
                                                                        ])

                                                                        <div class="d-flex justify-content-end gap-2">
                                                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">
                                                                                {{ __('dashboard.btn_cancel') }}
                                                                            </button>
                                                                            <button type="submit" class="btn btn-primary text-black waves-effect waves-light">
                                                                                {{__('dashboard.btn_create')}}
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @else

                                                    <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light"
                                                            data-bs-toggle="modal" data-bs-target="#serviceItem-section-edit-persona">
                                                        <i class="mdi mdi-pencil me-1"></i> Informações da sessão - Pessoas
                                                    </button>

                                                    <div class="modal fade" id="serviceItem-section-edit-persona" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h4 class="modal-title">{{__('dashboard.btn_save')}} - Sessão Pessoas</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>

                                                                <div class="modal-body p-4">
                                                                    <form action="{{ route('admin.dashboard.serviceSection.update', ['serviceSection' => $serviceSection['advantages_persona']['id']]) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.advantageSection.form", [
                                                                            'serviceSection',
                                                                            'serviceItem',
                                                                            'themeData',
                                                                            'forYou' => 'persona'
                                                                        ])

                                                                        <div class="d-flex justify-content-end gap-2">
                                                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">
                                                                                {{ __('dashboard.btn_cancel') }}
                                                                            </button>
                                                                            <button type="submit" class="btn btn-primary text-black waves-effect waves-light">
                                                                                {{__('dashboard.btn_save')}}
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endif


                                                {{-- Vantagens para Empresas --}}
                                                @if (empty($serviceSection['advantages_enterprise']))

                                                    <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light"
                                                            data-bs-toggle="modal" data-bs-target="#serviceItem-section-create-enterprise">
                                                        <i class="mdi mdi-plus-circle me-1"></i> Informações da sessão - Empresas
                                                    </button>

                                                    <div class="modal fade" id="serviceItem-section-create-enterprise" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h4 class="modal-title">{{__('dashboard.btn_create')}} - Sessão Empresas</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>

                                                                <div class="modal-body p-4">
                                                                    <form action="{{ route('admin.dashboard.serviceSection.store') }}" method="POST" enctype="multipart/form-data">
                                                                        @csrf

                                                                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.advantageSection.form", [
                                                                            'textareaId' => 'textarea-create-enterprise',
                                                                            'serviceSection',
                                                                            'serviceItem',
                                                                            'themeData',
                                                                            'forYou' => 'enterprise'
                                                                        ])

                                                                        <div class="d-flex justify-content-end gap-2">
                                                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">
                                                                                {{__('dashboard.btn_cancel') }}
                                                                            </button>
                                                                            <button type="submit" class="btn btn-primary text-black waves-effect waves-light">
                                                                                {{__('dashboard.btn_create')}}
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @else

                                                    <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light"
                                                            data-bs-toggle="modal" data-bs-target="#serviceItem-section-edit-enterprise">
                                                        <i class="mdi mdi-pencil me-1"></i> Informações da sessão - Empresas
                                                    </button>

                                                    <div class="modal fade" id="serviceItem-section-edit-enterprise" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h4 class="modal-title">{{__('dashboard.btn_save')}} - Sessão Empresas</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>

                                                                <div class="modal-body p-4">
                                                                    <form action="{{ route('admin.dashboard.serviceSection.update', ['serviceSection' => $serviceSection['advantages_enterprise']['id']]) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.advantageSection.form", [
                                                                            'serviceSection',
                                                                            'serviceItem',
                                                                            'themeData',
                                                                            'forYou' => 'enterprise'
                                                                        ])

                                                                        <div class="d-flex justify-content-end gap-2">
                                                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">
                                                                                {{ __('dashboard.btn_cancel') }}
                                                                            </button>
                                                                            <button type="submit" class="btn btn-primary text-black waves-effect waves-light">
                                                                                {{__('dashboard.btn_save')}}
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endif

                                            @endif


                                            @if (Auth::user()->hasPermissionTo('vantagens.visualizar') &&
                                            Auth::user()->hasPermissionTo('vantagens.criar') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                @if (isset($advantages) && $advantages->count() < $advantageLimit)                                                    
                                                    <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#advantage-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="advantage-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="advantage modal-dialog modal-dialog-centered" style="max-width: 1280px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>
                                                                <div class="modal-body p-4">
                                                                    <form action="{{route('admin.dashboard.advantage.store')}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf

                                                                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.advantage.form", ['textareaId' => 'textarea-create', 'themeData'])

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
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table-sortable table table-centered table-nowrap table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="bs-checkbox">
                                                    <label><input name="btnSelectAll" type="checkbox"></label>
                                                </th>
                                                {{-- <th>Link</th> --}}
                                                <th>Título</th>
                                                <th>Imagem</th>
                                                <th>Status</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>
                                        
                                        @foreach($advantages as $key => $advantage)                                            
                                            <tbody data-route="{{route('admin.dashboard.advantage.sorting')}}">
                                                @php
                                                    if ( $advantage->advantage_category_id) {
                                                        $categoria = $advantageCategory[$advantage->advantage_category_id] ?? 'Nenhuma categoria';
                                                    } 
                                                    \Carbon\Carbon::setLocale('pt_BR');
                                                    $dataFormatada = \Carbon\Carbon::parse($advantage->date)->translatedFormat('d \d\e F \d\e Y');
                                                @endphp

                                                <tr data-code="{{$advantage->id}}">
                                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="{{$advantage->id}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$advantage->id}}"></label>
                                                    </td>
                                                    <td>{{substr(strip_tags($advantage->title), 0, 40)}}...</td>
                                                    <td class="table-user text-start">
                                                        @if ($advantage->path_image)
                                                            <img src="{{ asset('storage/'.$advantage->path_image) }}" name="path_image" alt="table-user" class="me-2 rounded-circle">
                                                        @endif
                                                    </td>
                                                    <td class="text-start">
                                                        @switch($advantage->active)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        @if (Auth::user()->hasPermissionTo('vantagens.visualizar') &&
                                                        Auth::user()->hasPermissionTo('vantagens.editar') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <button data-bs-toggle="modal" data-bs-target="#advantage-edit-{{$advantage->id}}" class="tabledit-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                            <div class="modal fade" id="advantage-edit-{{$advantage->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="advantage modal-dialog modal-dialog-centered" style="max-width: 1280px;">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-light">
                                                                            <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_edit')}}</h4>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div>
                                                                        <div class="modal-body p-4">
                                                                            <form action="{{ route('admin.dashboard.advantage.update', ['advantage' => $advantage->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                
                                                                                @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.advantage.form", ['advantages', 'advantage', 'themeData'])

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

                                                        @if (Auth::user()->hasPermissionTo('vantagens.visualizar') &&
                                                        Auth::user()->hasPermissionTo('vantagens.remover') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <form action="{{route('admin.dashboard.advantage.destroy',['advantage' => $advantage->id])}}" style="width: 30px" method="POST">
                                                                @method('DELETE') @csrf        
                                                                
                                                                <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                                            </form>                                                    
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach                                           
                                        
                                    </table>
                                </div>

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                   {{-- {{$advantage->links()}} --}}
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    <style>
        .cke_notification_warning{
            opacity: -1;
            z-index: -2;
        }
        .cke_chrome{
            width: 100%;
        }
    </style>

@endsection
