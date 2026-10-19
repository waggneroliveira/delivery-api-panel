@extends('admin.core.admin')

@section('content')

    <div class="content-page">
        <div class="content">

            <div class="container-fluid">

                {{-- ============================================================
                PAGE TITLE
                ============================================================ --}}
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
                                        Planos
                                    </li>

                                </ol>
                            </div>

                            <h4 class="page-title">
                                Planos
                            </h4>

                        </div>

                    </div>
                </div>


                {{-- ============================================================
                MAIN CARD
                ============================================================ --}}
                <div class="row">

                    <div class="col-12">

                        <div class="card">

                            <div class="card-body">

                                {{-- ====================================================
                                HEADER
                                ==================================================== --}}
                                <div class="row mb-3">

                                    <div class="col-12 d-flex justify-content-between align-items-center">

                                        <div>
                                            <h4 class="header-title mb-1">
                                                Planos disponíveis
                                            </h4>

                                            <p class="text-muted mb-0">
                                                Gerencie os planos e limites de conteúdo dos clientes.
                                            </p>
                                        </div>


                                        {{-- ====================================================
                                        CREATE
                                        ==================================================== --}}
                                        @if (
                                            Auth::user()->can('planos.criar') ||
                                            Auth::user()->can('usuario.tornar usuario master') ||
                                            Auth::user()->hasRole('Super')
                                        )

                                            <a
                                                href="{{ route('admin.dashboard.plans.create') }}"
                                                class="btn btn-primary text-black waves-effect waves-light"
                                            >
                                                <i class="mdi mdi-plus-circle me-1"></i>

                                                Novo plano
                                            </a>

                                        @endif

                                    </div>

                                </div>


                                {{-- ============================================================
                                TABLE
                                ============================================================ --}}
                                <div class="table-responsive">

                                    <table class="table table-centered table-nowrap table-striped">

                                        <thead>

                                            <tr>

                                                <th>
                                                    #
                                                </th>

                                                <th>
                                                    Plano
                                                </th>

                                                <th>
                                                    Slug
                                                </th>

                                                <th>
                                                    Preço Anual
                                                </th>

                                                <th>
                                                    Limites
                                                </th>

                                                <th>
                                                    Clientes
                                                </th>

                                                <th>
                                                    Status
                                                </th>

                                                <th style="width: 130px;">
                                                    Ações
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            @forelse ($plans as $plan)

                                                <tr>

                                                    {{-- ====================================================
                                                    ID
                                                    ==================================================== --}}
                                                    <td>
                                                        {{ $plan->id }}
                                                    </td>


                                                    {{-- ====================================================
                                                    NAME
                                                    ==================================================== --}}
                                                    <td>

                                                        <strong>
                                                            {{ $plan->name }}
                                                        </strong>

                                                    </td>


                                                    {{-- ====================================================
                                                    SLUG
                                                    ==================================================== --}}
                                                    <td>

                                                        <code>
                                                            {{ $plan->slug }}
                                                        </code>

                                                    </td>


                                                    {{-- ====================================================
                                                    PRICE
                                                    ==================================================== --}}
                                                    <td>

                                                        <strong>
                                                            R$
                                                            {{ number_format($plan->monthly_price, 2, ',', '.') }}
                                                        </strong>

                                                    </td>


                                                    {{-- ====================================================
                                                    LIMITS
                                                    ==================================================== --}}
                                                    <td>

                                                        @if ($plan->moduleLimits->count())

                                                            <div class="d-flex flex-wrap gap-1">

                                                                @foreach ($plan->moduleLimits as $moduleLimit)

                                                                    <span
                                                                        class="badge bg-light text-dark border"
                                                                        title="{{ $moduleLimit->module }}"
                                                                    >
                                                                        {{ str_replace('_', ' ', ucfirst($moduleLimit->module)) }}:
                                                                        {{ $moduleLimit->limit }}
                                                                    </span>

                                                                @endforeach

                                                            </div>

                                                        @else

                                                            <span class="text-muted">
                                                                Nenhum limite configurado
                                                            </span>

                                                        @endif

                                                    </td>


                                                    {{-- ====================================================
                                                    TENANTS
                                                    ==================================================== --}}
                                                    <td>

                                                        <span class="badge bg-info">

                                                            {{ $plan->tenants_count }}

                                                            {{ $plan->tenants_count == 1 ? 'cliente' : 'clientes' }}

                                                        </span>

                                                    </td>


                                                    {{-- ====================================================
                                                    STATUS
                                                    ==================================================== --}}
                                                    <td>

                                                        @if ($plan->active)

                                                            <span class="badge bg-success">
                                                                Ativo
                                                            </span>

                                                        @else

                                                            <span class="badge bg-danger">
                                                                Inativo
                                                            </span>

                                                        @endif

                                                    </td>


                                                    {{-- ====================================================
                                                    ACTIONS
                                                    ==================================================== --}}
                                                    <td>

                                                        <div class="d-flex gap-1">

                                                            {{-- EDIT --}}
                                                            @if (
                                                                Auth::user()->can('planos.editar') ||
                                                                Auth::user()->can('usuario.tornar usuario master') ||
                                                                Auth::user()->hasRole('Super')
                                                            )

                                                                <a
                                                                    href="{{ route('admin.dashboard.plans.edit', $plan) }}"
                                                                    class="btn btn-primary text-black btn-sm"
                                                                    title="Editar"
                                                                >
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </a>

                                                            @endif


                                                            {{-- ACTIVE / INACTIVE --}}
                                                            @if (
                                                                Auth::user()->can('planos.editar') ||
                                                                Auth::user()->can('usuario.tornar usuario master') ||
                                                                Auth::user()->hasRole('Super')
                                                            )

                                                                <form
                                                                    action="{{ route('admin.dashboard.plans.toggleActive', $plan) }}"
                                                                    method="POST"
                                                                >

                                                                    @csrf

                                                                    @method('PATCH')

                                                                    <button
                                                                        type="submit"
                                                                        class="btn btn-sm {{ $plan->active ? 'btn-warning' : 'btn-success' }}"
                                                                        title="{{ $plan->active ? 'Desativar' : 'Ativar' }}"
                                                                    >

                                                                        @if ($plan->active)

                                                                            <i class="mdi mdi-pause"></i>

                                                                        @else

                                                                            <i class="mdi mdi-play"></i>

                                                                        @endif

                                                                    </button>

                                                                </form>

                                                            @endif


                                                            {{-- DELETE --}}
                                                            @if (
                                                                Auth::user()->can('planos.remover') ||
                                                                Auth::user()->can('usuario.tornar usuario master') ||
                                                                Auth::user()->hasRole('Super')
                                                            )

                                                                @if ($plan->tenants_count == 0)

                                                                    <form
                                                                        action="{{ route('admin.dashboard.plans.destroy', $plan) }}"
                                                                        method="POST"
                                                                    >

                                                                        @csrf

                                                                        @method('DELETE')

                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-danger btn-sm btSubmitDeleteItem"
                                                                            title="Excluir"
                                                                        >
                                                                            <i class="mdi mdi-delete"></i>
                                                                        </button>

                                                                    </form>

                                                                @else

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-secondary btn-sm"
                                                                        disabled
                                                                        title="Plano possui clientes vinculados"
                                                                    >
                                                                        <i class="mdi mdi-lock"></i>
                                                                    </button>

                                                                @endif

                                                            @endif

                                                        </div>

                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>

                                                    <td
                                                        colspan="8"
                                                        class="text-center py-4"
                                                    >

                                                        <div class="text-muted">

                                                            <i class="mdi mdi-package-variant-closed fs-1 d-block mb-2"></i>

                                                            Nenhum plano cadastrado.

                                                        </div>

                                                    </td>

                                                </tr>

                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection