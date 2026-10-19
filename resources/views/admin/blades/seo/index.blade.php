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
                                    <li class="breadcrumb-item active">Seo Google</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Seo Google</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 d-flex justify-between">
                                        <div class="col-6">
                                            {{-- @if (Auth::user()->hasPermissionTo('sobre nos.visualizar') &&
                                            Auth::user()->hasPermissionTo('sobre nos.remover') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <button id="btSubmitDelete" data-route="{{route('admin.dashboard.seoGoogle.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                            @endif --}}
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            @if (Auth::user()->hasPermissionTo('sobre nos.visualizar') &&
                                            Auth::user()->hasPermissionTo('sobre nos.criar') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                @if (!$seoGoogle)                                                    
                                                    <a href="{{route('admin.dashboard.seoGoogle.create')}}" class="mdi mdi-plus-circle me-1 btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-striped">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Descrição</th>
                                                <th>Imagem Social</th>
                                                <th>Organização</th>
                                                <th>Telefone</th>
                                                <th>E-mail</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>

                                        @if (isset($seoGoogle))

                                            <tbody>

                                                <tr>

                                                    {{-- Título --}}
                                                    <td>
                                                        {{ \Illuminate\Support\Str::limit($seoGoogle->title ?? 'Não informado', 35) }}
                                                    </td>

                                                    {{-- Description --}}
                                                    <td>
                                                        {{ \Illuminate\Support\Str::limit($seoGoogle->description ?? 'Não informado', 50) }}
                                                    </td>

                                                    {{-- Imagem Social --}}
                                                    <td class="table-user text-start">
                                                        @if ($seoGoogle->social_image)

                                                            <img
                                                                src="{{ asset('storage/' . $seoGoogle->social_image) }}"
                                                                alt="{{ $seoGoogle->title ?? 'Imagem SEO' }}"
                                                                class="me-2 rounded"
                                                                style="width: 45px; height: 45px; object-fit: cover;"
                                                            >

                                                        @else
                                                            <span class="text-muted">
                                                                Não definida
                                                            </span>
                                                        @endif
                                                    </td>

                                                    {{-- Organização --}}
                                                    <td>
                                                        {{ \Illuminate\Support\Str::limit($seoGoogle->organization_name ?? 'Não informado', 30) }}
                                                    </td>

                                                    {{-- Telefone --}}
                                                    <td>
                                                        {{ $seoGoogle->telephone ?? 'Não informado' }}
                                                    </td>

                                                    {{-- E-mail --}}
                                                    <td>
                                                        {{ $seoGoogle->email ?? 'Não informado' }}
                                                    </td>

                                                    {{-- Ações --}}
                                                    <td class="d-flex gap-lg-1 justify-center">

                                                        @if (
                                                            Auth::user()->hasPermissionTo('slide.visualizar') &&
                                                            Auth::user()->hasPermissionTo('slide.editar') ||
                                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') ||
                                                            Auth::user()->hasRole('Super')
                                                        )

                                                            <a
                                                                href="{{ route('admin.dashboard.seoGoogle.edit', ['seoGoogle' => $seoGoogle->id]) }}"
                                                                class="mdi mdi-pencil table-edit-button btn btn-primary text-black"
                                                                style="padding: 2px 8px; width: 30px;"
                                                            ></a>

                                                        @endif

                                                    </td>

                                                </tr>

                                            </tbody>

                                        @endif

                                    </table>
                                </div>

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                   {{-- {{$seoGoogle->links()}} --}}
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
