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
                                    <li class="breadcrumb-item active">Passo a passo</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Passo a passo</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 d-flex justify-end">
                                        <div class="col-12 d-flex justify-content-end">
                                            @if (Auth::user()->can('passo a passo.visualizar') &&
                                            Auth::user()->can('passo a passo.criar') ||
                                            Auth::user()->can('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                @if (!isset($statute))                                                
                                                    <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#statute-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                                @endif
                                                <!-- Modal -->
                                                <div class="modal fade" id="statute-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1320px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-light">
                                                                <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <div class="modal-body p-2 px-3 px-md-4">
                                                                <form action="{{ route('admin.dashboard.statute.store') }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf

                                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.statutes.form", ['textareaId' => 'textarea-create', 'themeData'])

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
                                @if (isset($statute))                                    
                                    <div class="table-responsive">
                                        <table class="table-sortable table table-centered table-nowrap table-striped">
                                            <thead>
                                                <tr>
                                                    {{-- <th></th> --}}
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
        
                                            <tbody>
                                                <tr>
                                                    {{-- <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td> --}}
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="" name="btnSelectItem" class="btnSelectItem" type="checkbox" value=""></label>
                                                    </td>
                                                    <td>{{$statute->title}}</td>
                                                    <td class="table-statute text-start">
                                                        @if ($statute->path_file)
                                                            <img src="{{ asset('storage/'.$statute->path_file) }}" alt="table-statute" class="me-2 rounded-circle" style="width: 40px; height: 40px;">
                                                            @else      
                                                            <img src="{{asset('build/admin/images/statutes/statute-3.jpg')}}" alt="table-statute" class="me-2 rounded-circle">
                                                        @endif
                                                    </td> 
                                                    <td>
                                                        @switch($statute->active)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        @if (Auth::user()->can('passo a passo.visualizar') &&
                                                        Auth::user()->can('passo a passo.editar') ||
                                                        Auth::user()->can('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <button class="table-edit-button btn btn-primary text-black" data-bs-toggle="modal" data-bs-target="#modal-group-edit-{{$statute->id}}" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                            <div class="modal fade" id="modal-group-edit-{{$statute->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" style="max-width: 1320px;">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-light">
                                                                            <h4 class="modal-title" id="myCenterModalLabel">passo a passo</h4>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div>
                                                                        <div class="modal-body  p-2 px-3 px-md-4">
                                                                            <form action="{{ route('admin.dashboard.statute.update', ['statute' => $statute->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @method('PUT')   

                                                                                @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.statutes.form", ['statute', 'themeData'])

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

                                                        @if (Auth::user()->can('passo a passo.visualizar') &&
                                                        Auth::user()->can('passo a passo.remover') ||
                                                        Auth::user()->can('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <form action="{{route('admin.dashboard.statute.destroy',['statute' => $statute->id])}}" style="width: 30px" method="POST">
                                                                @method('DELETE') @csrf        
                                                                
                                                                <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                                            </form>                                                    
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                   {{-- {{$statute->links()}} --}}
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
