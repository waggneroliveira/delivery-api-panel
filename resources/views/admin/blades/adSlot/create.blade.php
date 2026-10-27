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

                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard.adSlot.index') }}">
                                            Espaços de anúncio
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        Cadastrar espaço
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

                        <form
                            action="{{ route('admin.dashboard.adSlot.store') }}"
                            method="POST"
                        >

                            @csrf

                            <div class="row">

                                <div class="col-12">

                                    <div class="card">

                                        <div class="card-body">

                                            <h4 class="header-title mb-3">
                                                Cadastrar espaço de anúncio
                                            </h4>

                                            <p class="text-muted mb-4">
                                                Defina as informações do espaço onde os anúncios poderão ser exibidos neste template.
                                            </p>

                                            @includeIf(
                                                'admin.blades.adSlot.form',
                                                [
                                                    'uid' => 'create',
                                                    'adSlot' => null,
                                                    'themeData' => $themeData,
                                                    'themeManager' => $themeManager
                                                ]
                                            )

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="d-flex justify-content-end gap-2">

                                <a
                                    href="{{ route('admin.dashboard.adSlot.index') }}"
                                    class="btn btn-danger waves-effect waves-light"
                                >
                                    {{ __('dashboard.btn_cancel') }}
                                </a>

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
                <!-- end row -->

            </div>
            <!-- container -->

        </div>
        <!-- content -->

    </div>
    <!-- content-page -->

@endsection