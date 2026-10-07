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

                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard.plans.index') }}">
                                        Planos
                                    </a>
                                </li>

                                <li class="breadcrumb-item active">
                                    Editar plano
                                </li>

                            </ol>
                        </div>

                        <h4 class="page-title">
                            Editar plano
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
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h4 class="header-title">
                                        Editar plano
                                    </h4>
                                    <p class="text-muted">
                                        Altere as informações e os limites de conteúdo
                                        deste plano.
                                    </p>
                                </div>
                            </div>


                            <form action="{{ route('admin.dashboard.plans.update', ['plan' => $plan->id]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('admin.blades.plans.form', ['plan' => $plan, 'isEdit' => true])

                                {{-- ====================================================
                                ACTIONS
                                ==================================================== --}}
                                <div class="d-flex justify-content-end gap-2 mt-4">

                                    <a
                                        href="{{ route('admin.dashboard.plans.index') }}"
                                        class="btn btn-danger waves-effect waves-light"
                                    >
                                        {{ __('dashboard.btn_cancel') }}
                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-primary text-black waves-effect waves-light"
                                    >
                                        <i class="mdi mdi-content-save me-1"></i>

                                        Salvar alterações
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>


@endsection
