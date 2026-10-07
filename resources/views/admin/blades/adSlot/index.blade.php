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
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            Dashboard
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        Espaços de anúncio
                                    </li>
                                </ol>
                            </div>

                            <h4 class="page-title">
                                Espaços de anúncio
                            </h4>

                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="row mb-2">

                                    <div class="col-12 d-flex justify-content-between align-items-center">

                                        <div>
                                            <h4 class="header-title mb-1">
                                                Espaços de anúncio
                                            </h4>

                                            <p class="text-muted mb-0">
                                                Gerencie os espaços disponíveis para exibição de anúncios neste template.
                                            </p>
                                        </div>

                                        <div>
                                            <a
                                                href="{{ route('admin.dashboard.adSlot.create') }}"
                                                class="mdi mdi-plus-circle me-1 btn btn-primary text-black waves-effect waves-light"
                                            >
                                                {{ __('dashboard.btn_create') }}
                                            </a>
                                        </div>

                                    </div>

                                </div>

                                <div class="table-responsive mt-3">

                                    <table class="table-sortable table table-centered table-nowrap table-striped">

                                        <thead>
                                            <tr>
                                                <th style="width: 40px;"></th>
                                                <th style="width: 40px;"></th>
                                                <th>Nome</th>
                                                <th>Slug</th>
                                                <th>Tipo</th>
                                                <th class="text-center">Anúncios</th>
                                                <th class="text-center">Status</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>

                                        <tbody
                                            data-route="{{ route('admin.dashboard.adSlot.index') }}"
                                        >

                                            @foreach ($adSlots as $key => $adSlot)

                                                <tr data-code="{{ $adSlot->id }}">

                                                    {{-- Drag --}}
                                                    <td>
                                                        <span class="btnDrag mdi mdi-drag-horizontal font-22"></span>
                                                    </td>

                                                    {{-- Checkbox --}}
                                                    <td class="bs-checkbox">
                                                        <label>
                                                            <input
                                                                data-index="{{ $key }}"
                                                                name="btnSelectItem"
                                                                class="btnSelectItem"
                                                                type="checkbox"
                                                                value="{{ $adSlot->id }}"
                                                            >
                                                        </label>
                                                    </td>

                                                    {{-- Nome --}}
                                                    <td>
                                                        <strong>
                                                            {{ $adSlot->name }}
                                                        </strong>

                                                        @if($adSlot->description)
                                                            <br>

                                                            <small class="text-muted">
                                                                {{ \Illuminate\Support\Str::limit($adSlot->description, 80) }}
                                                            </small>
                                                        @endif
                                                    </td>

                                                    {{-- Slug --}}
                                                    <td>
                                                        <code>
                                                            {{ $adSlot->slug }}
                                                        </code>
                                                    </td>

                                                    {{-- Tipo --}}
                                                    <td>
                                                        @switch($adSlot->exhibition)

                                                            @case('horizontal')
                                                                <span class="badge bg-primary">
                                                                    Horizontal Desktop
                                                                </span>
                                                                @break

                                                            @case('mobile')
                                                                <span class="badge bg-info">
                                                                    Horizontal Mobile
                                                                </span>
                                                                @break

                                                            @case('vertical')
                                                                <span class="badge bg-secondary">
                                                                    Vertical
                                                                </span>
                                                                @break

                                                            @default
                                                                <span class="badge bg-dark">
                                                                    {{ $adSlot->exhibition }}
                                                                </span>

                                                        @endswitch
                                                    </td>

                                                    {{-- Anúncios vinculados --}}
                                                    <td class="text-center">

                                                        <span class="badge bg-light text-dark">
                                                            {{ $adSlot->announcements_count ?? 0 }}
                                                        </span>

                                                    </td>

                                                    {{-- Status --}}
                                                    <td class="text-center">

                                                        @if($adSlot->active)
                                                            <span class="badge bg-success">
                                                                Ativo
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger">
                                                                Inativo
                                                            </span>
                                                        @endif

                                                    </td>

                                                    {{-- Ações --}}
                                                    <td class="d-flex gap-lg-1 justify-center">

                                                        <a
                                                            href="{{ route('admin.dashboard.adSlot.edit', ['adSlot' => $adSlot->id]) }}"
                                                            class="mdi mdi-pencil table-edit-button btn btn-primary text-black"
                                                            style="padding: 2px 8px;width: 30px"
                                                            title="Editar"
                                                        ></a>

                                                      
                                                            <form
                                                                action="{{ route('admin.dashboard.adSlot.destroy', ['adSlot' => $adSlot->id]) }}"
                                                                style="width: 30px"
                                                                method="POST"
                                                            >

                                                                @method('DELETE')
                                                                @csrf

                                                                <button
                                                                    type="button"
                                                                    style="width: 30px"
                                                                    class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"
                                                                    title="Excluir"
                                                                >
                                                                    <i class="fa fa-times"></i>
                                                                </button>

                                                            </form>                                                        

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                                {{-- Estado vazio --}}
                                @if($adSlots->isEmpty())

                                    <div class="text-center py-5">

                                        <div class="mb-3">
                                            <i class="mdi mdi-bullhorn-outline font-36 text-muted"></i>
                                        </div>

                                        <h4 class="text-muted">
                                            Nenhum espaço de anúncio cadastrado
                                        </h4>

                                        <p class="text-muted mb-3">
                                            Cadastre um espaço para definir onde os anúncios poderão ser exibidos neste template.
                                        </p>
                                        
                                        <a
                                            href="{{ route('admin.dashboard.adSlot.create') }}"
                                            class="btn btn-primary text-black"
                                        >
                                            <i class="mdi mdi-plus-circle me-1"></i>
                                            {{ __('dashboard.btn_create') }}
                                        </a>

                                    </div>

                                @endif

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                    {{-- {{ $adSlots->links() }} --}}
                                </div>

                            </div>
                        </div>
                        <!-- end card-->

                    </div>
                    <!-- end col-->

                </div>
                <!-- end row -->

            </div>
            <!-- container -->

        </div>
        <!-- content -->

    </div>

    <style>
        .table td {
            vertical-align: middle;
        }

        .table code {
            font-size: 12px;
        }

        .btnDrag {
            cursor: grab;
        }

        .btnDrag:active {
            cursor: grabbing;
        }
    </style>

@endsection