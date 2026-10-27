@extends('admin.core.admin')

@section('content')

    <div class="content-page">
        <div class="content">

            <div class="container-fluid">

                {{-- PAGE TITLE --}}
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        Destaques
                                    </li>
                                </ol>
                            </div>

                            <h4 class="page-title">
                                Destaques
                            </h4>

                        </div>
                    </div>
                </div>

                {{-- CONTENT --}}
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                {{-- CREATE --}}
                                <div class="row mb-2">
                                    <div class="col-12 d-flex justify-content-end">
                                        @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['destaques.visualizar', 'destaques.criar']))
                                            @if (empty($serviceSection['pilar']))
                                            
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
                                                                    
                                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.impactSectionPilar.form", ['serviceSection', 'serviceItem', 'themeData'])
                                                                    
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
                                                                <form action="{{route('admin.dashboard.serviceSection.update', ['serviceSection' => $serviceSection['pilar']['id']])}}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                
                                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.impactSectionPilar.form", ['serviceSection', 'serviceItem', 'themeData'])
                                                                    
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

                                        @if (
                                            Auth::user()->can('destaques.visualizar') &&
                                            Auth::user()->can('destaques.criar') ||
                                            Auth::user()->can('usuario.tornar usuario master') ||
                                            Auth::user()->hasRole('Super')
                                        )

                                            @if (isset($impactSections) && $impactSections->count() < $impactSectionsLimit)

                                                <button
                                                    type="button"
                                                    class="btn btn-primary text-black waves-effect waves-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#impactSection-create"
                                                >
                                                    <i class="mdi mdi-plus-circle me-1"></i>
                                                    {{ __('dashboard.btn_create') }}
                                                </button>

                                            @endif

                                            {{-- CREATE MODAL --}}
                                            <div
                                                class="modal fade"
                                                id="impactSection-create"
                                                tabindex="-1"
                                                role="dialog"
                                                aria-hidden="true"
                                            >
                                                <div
                                                    class="modal-dialog modal-dialog-centered"
                                                    style="max-width: 980px;"
                                                >

                                                    <div class="modal-content">

                                                        <div class="modal-header bg-light">

                                                            <h4 class="modal-title">
                                                                {{ __('dashboard.btn_create') }}
                                                            </h4>

                                                            <button
                                                                type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="modal"
                                                                aria-hidden="true"
                                                            ></button>

                                                        </div>

                                                        <div class="modal-body p-2 px-3 px-md-4">

                                                            <form
                                                                action="{{ route('admin.dashboard.impactSection.store') }}"
                                                                method="POST"
                                                                enctype="multipart/form-data"
                                                            >

                                                                @csrf

                                                                @includeIf(
                                                                    "admin.templates.{$themeData->slug}.{$themeData->template_variation}.impactSection.form",
                                                                    [
                                                                        'impactSection' => null,
                                                                        'themeData' => $themeData
                                                                    ]
                                                                )

                                                                <div class="d-flex justify-content-end gap-2">

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-danger waves-effect waves-light"
                                                                        data-bs-dismiss="modal"
                                                                    >
                                                                        {{ __('dashboard.btn_cancel') }}
                                                                    </button>

                                                                    <button
                                                                        type="submit"
                                                                        class="btn btn-primary text-black waves-effect waves-light"
                                                                    >
                                                                        {{ __('dashboard.btn_create') }}
                                                                    </button>

                                                                </div>

                                                            </form>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                        @endif

                                    </div>
                                </div>

                                {{-- TABLE --}}
                                <div class="table-responsive">

                                    <table class="table-sortable table table-centered table-nowrap table-striped">

                                        <thead>
                                            <tr>

                                                <th class="bs-checkbox">
                                                    <label>
                                                        <input
                                                            name="btnSelectAll"
                                                            type="checkbox"
                                                        >
                                                    </label>
                                                </th>

                                                <th>Título</th>

                                                <th>Arquivo</th>

                                                <th>Status</th>

                                                <th style="width: 85px;">
                                                    Ações
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach($impactSections as $key => $impactSection)

                                                <tr>

                                                    <td class="bs-checkbox">
                                                        <label>
                                                            <input
                                                                data-index=""
                                                                name="btnSelectItem"
                                                                class="btnSelectItem"
                                                                type="checkbox"
                                                                value=""
                                                            >
                                                        </label>
                                                    </td>

                                                    <td>
                                                        {{ $impactSection->title }}
                                                    </td>

                                                    <td class="table-user">

                                                        @if ($impactSection->path_file)

                                                            <a
                                                                href="{{ asset('storage/'.$impactSection->path_file) }}"
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                download="arquivo"
                                                            >
                                                                <span class="mdi mdi-file-download-outline"></span>
                                                            </a>

                                                        @endif

                                                    </td>

                                                    <td>

                                                        @switch($impactSection->active)

                                                            @case(0)

                                                                <span class="badge bg-danger">
                                                                    Inativo
                                                                </span>

                                                            @break

                                                            @case(1)

                                                                <span class="badge bg-success">
                                                                    Ativo
                                                                </span>

                                                            @break

                                                        @endswitch

                                                    </td>

                                                    <td class="d-flex gap-lg-1 justify-center">

                                                        {{-- EDIT --}}
                                                        @if (
                                                            Auth::user()->can('destaques.visualizar') &&
                                                            Auth::user()->can('destaques.editar') ||
                                                            Auth::user()->can('usuario.tornar usuario master') ||
                                                            Auth::user()->hasRole('Super')
                                                        )

                                                            <button
                                                                class="table-edit-button btn btn-primary text-black"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-group-edit-{{ $impactSection->id }}"
                                                                style="padding: 2px 8px;width: 30px"
                                                            >
                                                                <span class="mdi mdi-pencil"></span>
                                                            </button>

                                                            {{-- EDIT MODAL --}}
                                                            <div
                                                                class="modal fade"
                                                                id="modal-group-edit-{{ $impactSection->id }}"
                                                                tabindex="-1"
                                                                role="dialog"
                                                                aria-hidden="true"
                                                            >

                                                                <div
                                                                    class="modal-dialog modal-dialog-centered"
                                                                    style="max-width: 980px;"
                                                                >

                                                                    <div class="modal-content">

                                                                        <div class="modal-header bg-light">

                                                                            <h4 class="modal-title">
                                                                                Editar Destaque
                                                                            </h4>

                                                                            <button
                                                                                type="button"
                                                                                class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-hidden="true"
                                                                            ></button>

                                                                        </div>

                                                                        <div class="modal-body p-2 px-3 px-md-4">

                                                                            <form
                                                                                action="{{ route('admin.dashboard.impactSection.update', ['impactSection' => $impactSection->id]) }}"
                                                                                method="POST"
                                                                                enctype="multipart/form-data"
                                                                            >

                                                                                @csrf

                                                                                @method('PUT')

                                                                                @includeIf(
                                                                                    "admin.templates.{$themeData->slug}.{$themeData->template_variation}.impactSection.form",
                                                                                    [
                                                                                        'impactSection' => $impactSection,
                                                                                        'themeData' => $themeData
                                                                                    ]
                                                                                )

                                                                                <div class="d-flex justify-content-end gap-2">

                                                                                    <button
                                                                                        type="button"
                                                                                        class="btn btn-danger waves-effect waves-light"
                                                                                        data-bs-dismiss="modal"
                                                                                    >
                                                                                        {{ __('dashboard.btn_cancel') }}
                                                                                    </button>

                                                                                    <button
                                                                                        type="submit"
                                                                                        class="btn btn-primary text-black waves-effect waves-light"
                                                                                    >
                                                                                        {{ __('dashboard.btn_save') }}
                                                                                    </button>

                                                                                </div>

                                                                            </form>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        @endif

                                                        {{-- DELETE --}}
                                                        @if (
                                                            Auth::user()->can('destaques.visualizar') &&
                                                            Auth::user()->can('destaques.remover') ||
                                                            Auth::user()->can('usuario.tornar usuario master') ||
                                                            Auth::user()->hasRole('Super')
                                                        )

                                                            <form
                                                                action="{{ route('admin.dashboard.impactSection.destroy', ['impactSection' => $impactSection->id]) }}"
                                                                style="width: 30px"
                                                                method="POST"
                                                            >

                                                                @method('DELETE')
                                                                @csrf

                                                                <button
                                                                    type="button"
                                                                    style="width: 30px"
                                                                    class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"
                                                                >
                                                                    <i class="fa fa-times"></i>
                                                                </button>

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
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <style>
        .cke_notification_warning {
            opacity: -1;
            z-index: -2;
        }

        .cke_chrome {
            width: 100%;
        }
    </style>

@endsection

