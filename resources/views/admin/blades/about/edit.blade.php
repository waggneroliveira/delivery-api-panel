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
                                    <li class="breadcrumb-item active"><a href="{{route('admin.dashboard.about.index')}}">Sobre</a></li>
                                    <li class="breadcrumb-item active">Editar Sobre</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Sobre</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <form action="{{ route('admin.dashboard.about.update', ['about' => $about->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.about.form", ['about', 'themeData'])    
                        </div>
                        
                        @if(Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                            Auth::user()->hasRole('Super') || Auth::user()->hasPermissionTo('sobre nos.visualizar') && Auth::user()->hasPermissionTo('sobre nos.editar'))
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('admin.dashboard.about.index')}}" class="btn btn-danger waves-effect waves-light">{{__('dashboard.btn_cancel')}}</a>
                                <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_save')}}</button>
                            </div>        
                        @endif                                                                                                                                                                                    
                    </form>
                </div> <!-- fecha a row aberta -->

            </div> <!-- fecha container-fluid -->
        </div> <!-- fecha content -->
    </div> <!-- fecha content-page -->
@endsection