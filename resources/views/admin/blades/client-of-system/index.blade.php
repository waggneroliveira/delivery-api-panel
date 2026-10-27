@extends('admin.core.admin')
@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content -->
        <div class="container-fluid">
            {{-- ============================================================ PAGE TITLE ============================================================ --}}
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
                                    Clientes
                                </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            Clientes
                        </h4>
                    </div>
                </div>
            </div>
            {{-- ============================================================ MAIN CARD ============================================================ --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- ==================================================== TOP ACTIONS ==================================================== --}}
                            <div class="row mb-3">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    {{-- ================================================ DELETE SELECTED ================================================ --}}
                                    <div>
                                        @if (
                                            Auth::user()->can('clientes.visualizar') &&
                                            Auth::user()->can('clientes.remover') ||
                                            Auth::user()->can('usuario.tornar usuario master') ||
                                            Auth::user()->hasRole('Super')
                                        )
                                            {{-- <button id="btSubmitDelete" data-route="{{ route('admin.dashboard.tenants.destroySelected') }}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;" > {{ __('dashboard.btn_delete_all') }} </button> --}}
                                        @endif
                                    </div>
                                    {{-- ================================================ CREATE ================================================ --}}
                                    <div>
                                        @if (
                                            Auth::user()->can('clientes.visualizar') &&
                                            Auth::user()->can('clientes.criar') ||
                                            Auth::user()->can('usuario.tornar usuario master') ||
                                            Auth::user()->hasRole('Super')
                                        )
                                            <a
                                                href="{{ route('admin.dashboard.tenants.create') }}"
                                                class="btn btn-primary text-black waves-effect waves-light"
                                            >
                                                <i class="mdi mdi-plus-circle me-1"></i>
                                                {{ __('dashboard.btn_create') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- ==================================================== TABLE ==================================================== --}}
                            <div class="table-responsive">
                                <table class="table-sortable table table-centered table-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="bs-checkbox">
                                                <label>
                                                    <input
                                                        name="btnSelectAll"
                                                        type="checkbox"
                                                    >
                                                </label>
                                            </th>
                                            <th>
                                                Cliente
                                            </th>
                                            <th>
                                                Domínio
                                            </th>
                                            <th>
                                                Plano
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th style="width: 110px;">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>{{-- data-route="{{ route('admin.dashboard.tenants.sorting') }}" --}}
                                        @foreach ($clients as $key => $tenant)
                                            <tr data-code="{{ $tenant->id }}">
                                                {{-- ========================================== DRAG ========================================== --}}
                                                <td>
                                                    <span
                                                        class="btnDrag mdi mdi-drag-horizontal font-22"
                                                    ></span>
                                                </td>
                                                {{-- ========================================== CHECKBOX ========================================== --}}
                                                <td class="bs-checkbox">
                                                    <label>
                                                        <input
                                                            data-index="{{ $key }}"
                                                            name="btnSelectItem"
                                                            class="btnSelectItem"
                                                            type="checkbox"
                                                            value="{{ $tenant->id }}"
                                                        >
                                                    </label>
                                                </td>
                                                {{-- ========================================== CLIENT ========================================== --}}
                                                <td>
                                                    <div>
                                                        <strong>
                                                            {{ $tenant->name }}
                                                        </strong>
                                                        @if (!empty($tenant->email))
                                                            <div class="text-muted small">
                                                                {{ $tenant->email }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                {{-- ========================================== DOMAIN ========================================== --}}
                                                <td>
                                                    @if (!empty($tenant->domain))
                                                        <span class="text-muted">
                                                            {{ $tenant->domain }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">
                                                            —
                                                        </span>
                                                    @endif
                                                </td>
                                                {{-- ========================================== PLAN ========================================== --}}
                                                <td>
                                                    @if ($tenant->plan)
                                                        <span class="badge bg-primary">
                                                            {{ $tenant->plan->name }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            Sem plano
                                                        </span>
                                                    @endif
                                                </td>
                                                {{-- ========================================== STATUS ========================================== --}}
                                                <td>
                                                    @if ($tenant->active)
                                                        <span class="badge bg-success">
                                                            Ativo
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            Inativo
                                                        </span>
                                                    @endif
                                                </td>
                                                {{-- ========================================== ACTIONS ========================================== --}}
                                                <td class="d-flex gap-lg-1 justify-content-center">
                                                    {{-- ====================================== EDIT ====================================== --}}
                                                    @if (
                                                        Auth::user()->can('clientes.visualizar') &&
                                                        Auth::user()->can('clientes.editar') ||
                                                        Auth::user()->can('usuario.tornar usuario master') ||
                                                        Auth::user()->hasRole('Super')
                                                    )
                                                        <a
                                                            href="{{ route('admin.dashboard.tenants.edit', ['tenant' => $tenant->id]) }}"
                                                            class="btn btn-primary text-black btn-sm"
                                                            style="padding: 2px 8px; width: 30px;"
                                                            title="Editar"
                                                        >
                                                            <span class="mdi mdi-pencil"></span>
                                                        </a>
                                                    @endif
                                                    {{-- ====================================== SHOW ====================================== --}}
                                                    @if (
                                                        Auth::user()->can('clientes.visualizar') ||
                                                        Auth::user()->can('usuario.tornar usuario master') ||
                                                        Auth::user()->hasRole('Super')
                                                    )
                                                        <a
                                                            href="{{ route('admin.dashboard.tenants.show', ['tenant' => $tenant->id]) }}"
                                                            class="btn btn-info text-white btn-sm"
                                                            style="padding: 2px 8px; width: 30px;"
                                                            title="Visualizar"
                                                        >
                                                            <span class="mdi mdi-eye"></span>
                                                        </a>
                                                    @endif
                                                    {{-- ====================================== DELETE ====================================== --}}
                                                    @if (
                                                        Auth::user()->can('clientes.visualizar') &&
                                                        Auth::user()->can('clientes.remover') ||
                                                        Auth::user()->can('usuario.tornar usuario master') ||
                                                        Auth::user()->hasRole('Super')
                                                    )
                                                        <form
                                                            action="{{ route('admin.dashboard.tenants.destroy', ['tenant' => $tenant->id]) }}"
                                                            style="width: 30px;"
                                                            method="POST"
                                                        >
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                type="button"
                                                                style="width: 30px;"
                                                                class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"
                                                                title="Excluir"
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
                            {{-- ============================================================ EMPTY STATE ============================================================ --}}
                            @if ($clients->count() === 0)
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="mdi mdi-account-multiple-outline font-36 text-muted"></i>
                                    </div>
                                    <h5>
                                        Nenhum cliente cadastrado
                                    </h5>
                                    <p class="text-muted">
                                        Cadastre o primeiro cliente para começar.
                                    </p>
                                    @if (
                                        Auth::user()->can('clientes.criar') ||
                                        Auth::user()->can('usuario.tornar usuario master') ||
                                        Auth::user()->hasRole('Super')
                                    )
                                        <a
                                            href="{{ route('admin.dashboard.tenants.create') }}"
                                            class="btn btn-primary text-black"
                                        >
                                            <i class="mdi mdi-plus-circle me-1"></i>
                                            Cadastrar cliente
                                        </a>
                                    @endif
                                </div>
                            @endif
                            {{-- ============================================================ PAGINATION ============================================================ --}}
                            @if (method_exists($clients, 'links'))
                                <div class="mt-3 float-end">
                                    {{ $clients->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>
@endsection
