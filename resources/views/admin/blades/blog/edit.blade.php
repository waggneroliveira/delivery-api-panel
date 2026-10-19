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
                                <li class="breadcrumb-item active"><a href="{{route('admin.dashboard.blog.index')}}">Notícias</a></li>
                                <li class="breadcrumb-item active">Editar Notícia</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Editar Notícia</h4>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <form action="{{ route('admin.dashboard.blog.update', ['blog' => $blog->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.blog.form", ['blog', 'themeData'])       
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{route('admin.dashboard.blog.index')}}" class="btn btn-danger waves-effect waves-light">{{__('dashboard.btn_cancel')}}</a>
                        <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_save')}}</button>
                    </div>                                                                                                                                                                                            
                </form>
            </div> <!-- fecha a row aberta -->

        </div> <!-- fecha container-fluid -->
    </div> <!-- fecha content -->
</div> <!-- fecha content-page -->
@endsection