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
                                    <li class="breadcrumb-item active">Editais</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editais</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <form action="{{ route('admin.dashboard.noticies.index') }}" method="GET" class="mb-4">
                                            <div class="row g-3 align-items-end">

                                                <!-- Título -->
                                                <div class="col-md-6">
                                                    <label for="title" class="form-label">Título</label>
                                                    <input type="text" name="title" id="title" value="{{ request('title') }}" 
                                                        class="form-control" placeholder="Pesquisar por título">
                                                </div>

                                                <!-- Ano -->
                                                <div class="col-md-3">
                                                    <label for="date" class="form-label">Ano</label>
                                                    <select name="date" id="date" class="form-select">
                                                        <option value="">Todas</option>
                                                        @foreach($groupedNoticies as $year => $notice)
                                                            <option value="{{ $year }}" 
                                                                {{ request('date') == $year ? 'selected' : '' }}>
                                                                {{ $year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Botões -->
                                                <div class="col-md-3 d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary w-100 text-black">
                                                        <i class="bi bi-search text-black"></i> Filtrar
                                                    </button>

                                                    @if (request()->has('title') || request()->has('date'))
                                                        <a href="{{ route('admin.dashboard.noticies.index') }}" class="btn btn-outline-secondary w-100">
                                                            <i class="bi bi-x-circle"></i> Limpar
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-12 d-flex justify-between">
                                        <div class="col-6">
                                            @if (Auth::user()->can('editais.visualizar') &&
                                            Auth::user()->can('editais.remover') ||
                                            Auth::user()->can('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <button id="btSubmitDelete" data-route="{{route('admin.dashboard.noticies.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                            @endif
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            @if (Auth::user()->can('editais.visualizar') &&
                                            Auth::user()->can('editais.criar') ||
                                            Auth::user()->can('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#noticies-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="noticies-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" style="max-width: 980px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-light">
                                                                <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <div class="modal-body p-2 px-3 px-md-4">
                                                                <form action="{{ route('admin.dashboard.noticies.store') }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row g-3">
                                                                        <div class="mb-3 col-12 col-md-8">
                                                                            <label for="title" class="form-label">Título</label>
                                                                            <input 
                                                                                type="text" 
                                                                                name="title" 
                                                                                class="form-control" 
                                                                                id="title" 
                                                                                placeholder="Digite seu nome" 
                                                                                required
                                                                            >
                                                                        </div>
                                                                        <div class="mb-3 col-12 col-md-4">
                                                                            <label for="date" class="form-label">Data de publicação</label>
                                                                            <input 
                                                                                type="date" 
                                                                                name="date" 
                                                                                class="form-control" 
                                                                                id="date" 
                                                                                required
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="path_file" class="form-label">Arquivo</label>
                                                                        <input 
                                                                            type="file" 
                                                                            name="path_file" 
                                                                            accept="application/pdf" 
                                                                            data-plugins="dropify" 
                                                                            class="form-control" 
                                                                            required
                                                                            id="path_file"
                                                                        />
                                                                        <p class="text-muted text-center mt-2 mb-0">
                                                                            {{ __('dashboard.text_img_size') }} <b class="text-danger">2 MB</b>.
                                                                        </p>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3 form-check">
                                                                        <input 
                                                                            name="active" 
                                                                            type="checkbox" 
                                                                            class="form-check-input" 
                                                                            id="invalidCheck{{ isset($noticie->id) ? $noticie->id : '' }}" 
                                                                        />
                                                                        <label class="form-check-label" for="invalidCheck{{ isset($noticie->id) ? $noticie->id : '' }}">
                                                                            {{ __('dashboard.active') }}?
                                                                        </label>
                                                                        <div class="invalid-feedback">
                                                                            You must agree before submitting.
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="d-flex justify-content-end gap-2">
                                                                        <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">
                                                                            {{ __('dashboard.btn_cancel') }}
                                                                        </button>
                                                                        <button type="submit" class="btn btn-primary text-black waves-effect waves-light">
                                                                            {{ __('dashboard.btn_create') }}
                                                                        </button>
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
                                                <th>Ano</th>
                                                <th>Arquivo</th>
                                                <th>Status</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>
    
                                        <tbody data-route="{{route('admin.dashboard.noticies.sorting')}}">
                                            @foreach ($noticies as $key => $noticie)
                                                @php
                                                    $year = \Carbon\Carbon::parse($noticie->date)->format('Y')
                                                @endphp
                                                <tr data-code="{{$noticie->id}}">
                                                    {{-- <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td> --}}
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$noticie->id}}"></label>
                                                    </td>
                                                    <td>{{$noticie->title}}</td>
                                                    <td>{{$year}}</td>
                                                    <td class="table-user">
                                                        @if ($noticie->path_file)                                                            
                                                            <a href="{{ asset('storage/'.$noticie->path_file) }}" target="_blank" rel="noopener noreferrer" download="arquivo">
                                                                <span class="mdi mdi-file-download-outline"></span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @switch($noticie->active)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        @if (Auth::user()->can('editais.visualizar') &&
                                                        Auth::user()->can('editais.editar') ||
                                                        Auth::user()->can('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <button class="table-edit-button btn btn-primary text-black" data-bs-toggle="modal" data-bs-target="#modal-group-edit-{{$noticie->id}}" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                            <div class="modal fade" id="modal-group-edit-{{$noticie->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" style="max-width: 980px;">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-light">
                                                                            <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.group_and_permission')}}</h4>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div>
                                                                        <div class="modal-body  p-2 px-3 px-md-4">
                                                                            <form action="{{ route('admin.dashboard.noticies.update', ['noticies' => $noticie->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                @include('admin.blades.noticies.form', ['textareaId' => 'textarea-edit-' . $noticie->id])    
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

                                                        @if (Auth::user()->can('editais.visualizar') &&
                                                        Auth::user()->can('editais.remover') ||
                                                        Auth::user()->can('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <form action="{{route('admin.dashboard.noticies.destroy',['noticies' => $noticie->id])}}" style="width: 30px" method="POST">
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
                                   {{-- {{$noticies->links()}} --}}
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
