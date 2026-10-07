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
                                    <li class="breadcrumb-item active">Planos de internet</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Planos de internet</h4>
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
                                        <div class="col-6">
                                            @if (Auth::user()->hasPermissionTo('plano.visualizar') &&
                                            Auth::user()->hasPermissionTo('plano.remover') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <button id="btSubmitDelete" data-route="{{route('admin.dashboard.planNetwork.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                            @endif
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            @if (Auth::user()->hasPermissionTo('plano.visualizar') &&
                                                Auth::user()->hasPermissionTo('plano.editar') ||
                                                Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                Auth::user()->hasRole('Super'))
                                                @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['serviceItem.visualizar', 'serviceItem.criar']))
                                                    @if (empty($serviceSection['planNetwork']))
                                                    
                                                        <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#serviceItem-section-create"><i class="mdi mdi-plus-circle me-1"></i> Informações da sessão</button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="serviceItem-section-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                    </div>
                                                                    <div class="modal-body p-4">
                                                                        <form action="{{route('admin.dashboard.serviceSection.store')}}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            
                                                                            @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.planNetworkSection.form", ['textareaId' => 'textarea-create', 'serviceSection', 'serviceItem', 'themeData'])
                                                                            
                                                                            <div class="d-flex justify-content-end gap-2">
                                                                                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
                                                                                <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</button>
                                                                            </div>                                                 
                                                                        </form>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->
                                                        @else
                                                        <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#serviceItem-section-edit"><i class="mdi mdi-plus-circle me-1"></i> Informações da sessão</button>
                                                        <!-- Modal Edit -->
                                                        <div class="modal fade" id="serviceItem-section-edit" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                    </div>
                                                                    <div class="modal-body p-4">
                                                                        <form action="{{route('admin.dashboard.serviceSection.update', ['serviceSection' => $serviceSection['planNetwork']['id']])}}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                        
                                                                            @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.planNetworkSection.form", ['serviceSection', 'serviceItem', 'themeData'])
                                                                            
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
                                            @endif


                                            @if (Auth::user()->hasPermissionTo('plano.visualizar') &&
                                            Auth::user()->hasPermissionTo('plano.criar') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                @if (isset($plans) && $plans->count() < $planLimit)
                                                    <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#plan-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                                @endif  
                                                <!-- Modal -->
                                                <div class="modal fade" id="plan-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="plan modal-dialog modal-dialog-centered" style="max-width: 760px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-light">
                                                                <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <div class="modal-body p-4">
                                                                <form action="{{route('admin.dashboard.planNetwork.store')}}" method="POST" enctype="multipart/form-data">
                                                                    @csrf  
                                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.planNetwork.form", ['textareaId' => 'textarea-create', 'planNetwork', 'themeData'])

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
                                    <table class="table-sortable table table-centered table-nowrap table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="bs-checkbox">
                                                    <label><input name="btnSelectAll" type="checkbox"></label>
                                                </th>
                                                {{-- <th>Link</th> --}}
                                                <th>Título</th>
                                                <th>Categoria</th>
                                                <th>Criado</th>
                                                <th>Status</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>
    
                                        <tbody data-route="{{route('admin.dashboard.planNetwork.sorting')}}">
                                            @foreach ($plans as $key => $plan)
                                                @php
                                                    if ($plan->plan_network_category) {
                                                        $categoria = $planCategory[$plan->plan_network_category] ?? 'Nenhuma categoria';
                                                    } 
                                                    \Carbon\Carbon::setLocale('pt_BR');
                                                    $dataFormatada = \Carbon\Carbon::parse($plan->date)->translatedFormat('d \d\e F \d\e Y');
                                                @endphp

                                                <tr data-code="{{$plan->id}}">
                                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$plan->id}}"></label>
                                                    </td>
                                                    <td>{{substr(strip_tags($plan->title), 0, 40)}}...</td>
                                                    <td>{{$categoria}}</td>
                                                    <td>{{$dataFormatada}}</td>
                                                    <td class="text-center">
                                                        @switch($plan->active)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        @if (Auth::user()->hasPermissionTo('plano.visualizar') &&
                                                        Auth::user()->hasPermissionTo('plano.editar') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                        <button data-bs-toggle="modal" data-bs-target="#plan-edit-{{$plan->id}}" class="tabledit-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                        <div class="modal fade" id="plan-edit-{{$plan->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="plan modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_edit')}}</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                    </div>
                                                                    <div class="modal-body p-4">
                                                                        <form action="{{ route('admin.dashboard.planNetwork.update', ['planNetwork' => $plan->id]) }}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')  
                                                                            @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.planNetwork.form", ['textareaId' => 'textarea-edit-plan-' . $plan->id, 'planNetwork', 'themeData'])

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

                                                        @if (Auth::user()->hasPermissionTo('plano.visualizar') &&
                                                        Auth::user()->hasPermissionTo('plano.remover') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <form action="{{route('admin.dashboard.planNetwork.destroy',['planNetwork' => $plan->id])}}" style="width: 30px" method="POST">
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

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                   {{-- {{$plan->links()}} --}}
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
