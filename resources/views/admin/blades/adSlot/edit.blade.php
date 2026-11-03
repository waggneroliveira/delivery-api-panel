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
                                        <a href="{{ route('admin.dashboard.adSlot.index') }}">
                                            Espaços de anúncio
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        Editar espaço
                                    </li>

                                </ol>

                            </div>

                            <h4 class="page-title">
                                Editar espaço de anúncio
                            </h4>

                        </div>

                    </div>

                </div>

                <!-- end row -->

                <div class="row">

                    <div class="col-12">

                        <form
                            action="{{ route('admin.dashboard.adSlot.update', ['adSlot' => $adSlot->id]) }}"
                            method="POST"
                        >

                            @csrf

                            @method('PUT')

                            <div class="row">

                                <div class="col-12">

                                    <div class="card">

                                        <div class="card-body">

                                            <h4 class="header-title mb-3">
                                                Editar espaço de anúncio
                                            </h4>

                                            <p class="text-muted mb-4">
                                                Atualize as informações do espaço de anúncio deste template.
                                            </p>

                                            @includeIf(
                                                'admin.blades.adSlot.form',
                                                [
                                                    'uid' => $adSlot->id,
                                                    'adSlot' => $adSlot,
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
                                    {{ __('dashboard.btn_save') }}
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