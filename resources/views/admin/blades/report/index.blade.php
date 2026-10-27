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
                                    <li class="breadcrumb-item active">Missão Visão e Valores</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Missão Visão e Valores</h4>
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
                                            @if (Auth::user()->can('missao visao e valores.visualizar') &&
                                            Auth::user()->can('missao visao e valores.criar') ||
                                            Auth::user()->can('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                @if ($reports->count() < 3)                                                
                                                    <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#report-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                                @endif
                                                <!-- Modal -->
                                                <div class="modal fade" id="report-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" style="max-width: 980px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-light">
                                                                <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <div class="modal-body p-2 px-3 px-md-4">
                                                                <form action="{{ route('admin.dashboard.report.store') }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    
                                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.report.form", ['report', 'themeData'])
 
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
                                                {{-- <th></th> --}}
                                                <th class="bs-checkbox">
                                                    <label><input name="btnSelectAll" type="checkbox"></label>
                                                </th>
                                                {{-- <th>Link</th> --}}
                                                <th>Título</th>
                                                <th>Arquivo</th>
                                                <th>Status</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>
    
                                        <tbody>
                                            @foreach ($reports as $report)                                                
                                                <tr>
                                                    {{-- <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td> --}}
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="" name="btnSelectItem" class="btnSelectItem" type="checkbox" value=""></label>
                                                    </td>
                                                    <td>{{$report->title}}</td>
                                                    <td class="table-user">
                                                        @if ($report->path_file)                                                            
                                                            <a href="{{ asset('storage/'.$report->path_file) }}" target="_blank" rel="noopener noreferrer" download="arquivo">
                                                                <span class="mdi mdi-file-download-outline"></span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @switch($report->active)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        @if (Auth::user()->can('missao visao e valores.visualizar') &&
                                                        Auth::user()->can('missao visao e valores.editar') ||
                                                        Auth::user()->can('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <button class="table-edit-button btn btn-primary text-black" data-bs-toggle="modal" data-bs-target="#modal-group-edit-{{$report->id}}" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                            <div class="modal fade" id="modal-group-edit-{{$report->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" style="max-width: 980px;">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-light">
                                                                            <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.group_and_permission')}}</h4>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div>
                                                                        <div class="modal-body  p-2 px-3 px-md-4">
                                                                            <form action="{{ route('admin.dashboard.report.update', ['report' => $report->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                
                                                                                @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.report.form", ['report', 'themeData'])

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

                                                        @if (Auth::user()->can('missao visao e valores.visualizar') &&
                                                        Auth::user()->can('missao visao e valores.remover') ||
                                                        Auth::user()->can('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <form action="{{route('admin.dashboard.report.destroy',['report' => $report->id])}}" style="width: 30px" method="POST">
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
                                   {{-- {{$report->links()}} --}}
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
