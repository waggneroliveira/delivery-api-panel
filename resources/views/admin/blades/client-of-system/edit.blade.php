@extends('admin.core.admin')

@section('content')

<div class="content-page">

    <div class="content">

        <!-- Start Content -->
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

                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard.tenants.index') }}">
                                        Clientes
                                    </a>
                                </li>

                                <li class="breadcrumb-item active">
                                    Editar cliente
                                </li>

                            </ol>

                        </div>

                        <h4 class="page-title">
                            Editar cliente
                        </h4>

                    </div>

                </div>

            </div>


            {{-- ============================================================
            FORM
            ============================================================ --}}

            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">

                            <form
                                action="{{ route('admin.dashboard.tenants.update', ['tenant' => $tenant->id]) }}"
                                method="POST" enctype="multipart/form-data"
                            >

                                @csrf

                                @method('PUT')


                                {{-- ====================================================
                                DADOS DO CLIENTE
                                ==================================================== --}}

                                <div class="row">

                                    <div class="col-12">

                                        <h5 class="mb-1">
                                            Dados do cliente
                                        </h5>

                                        <p class="text-muted mb-3">
                                            Atualize os dados do cliente, plano e limites personalizados.
                                        </p>

                                    </div>

                                </div>


                                {{-- ====================================================
                                FORMULÁRIO
                                ==================================================== --}}

                                @include('admin.blades.tenant.form',
                                    [
                                        'tenant' => $tenant,
                                        'plans' => $plans,
                                        'availableModules' => $availableModules,
                                        'tenantModuleLimits' => $tenantModuleLimits,
                                        'formPrefix' => 'edit'
                                    ]
                                )


                                {{-- ====================================================
                                BUTTONS
                                ==================================================== --}}

                                <div class="row mt-4">

                                    <div class="col-12">

                                        <div class="d-flex justify-content-end gap-2">

                                            <a
                                                href="{{ route('admin.dashboard.tenants.index') }}"
                                                class="btn btn-danger waves-effect waves-light"
                                            >
                                                {{ __('dashboard.btn_cancel') }}
                                            </a>

                                            <button
                                                type="submit"
                                                class="btn btn-primary text-black waves-effect waves-light"
                                            >
                                                <i class="mdi mdi-content-save me-1"></i>
                                                {{ __('dashboard.btn_save') }}
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!-- container -->

    </div>
    <!-- content -->

</div>
@endsection
