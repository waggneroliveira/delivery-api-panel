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
                                    <li class="breadcrumb-item active">Notícias</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Notícias</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <form action="{{ route('admin.dashboard.blog.index') }}" method="GET" class="mb-4">
                                            <div class="row g-3 align-items-end">

                                                <!-- Título -->
                                                <div class="col-md-5">
                                                    <label for="title" class="form-label">Título</label>
                                                    <input type="text" name="title" id="title" value="{{ request('title') }}" 
                                                        class="form-control" placeholder="Pesquisar por título">
                                                </div>

                                                <!-- Data -->
                                                <div class="col-md-2">
                                                    <label for="date" class="form-label">Data</label>
                                                    <input type="date" name="date" id="date" value="{{ request('date') }}" 
                                                        class="form-control">
                                                </div>

                                                <!-- Categoria -->
                                                <div class="col-md-2">
                                                    <label for="blog_category_id" class="form-label">Categoria</label>
                                                    <select name="blog_category_id" id="blog_category_id" class="form-select">
                                                        <option value="">Todas</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" 
                                                                {{ request('blog_category_id') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Botões -->
                                                <div class="col-md-3 d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary w-100 text-black">
                                                        <i class="bi bi-search text-black"></i> Filtrar
                                                    </button>

                                                    @if (request()->has('title') || request()->has('date') || request()->has('blog_category_id'))
                                                        <a href="{{ route('admin.dashboard.blog.index') }}" class="btn btn-outline-secondary w-100">
                                                            <i class="bi bi-x-circle"></i> Limpar
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 d-flex justify-between">
                                        <div class="col-6">
                                            @if (Auth::user()->hasPermissionTo('noticias.visualizar') &&
                                            Auth::user()->hasPermissionTo('noticias.remover') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <button id="btSubmitDelete" data-route="{{route('admin.dashboard.blog.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                            @endif
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            @if (Auth::user()->hasPermissionTo('noticias.visualizar') &&
                                            Auth::user()->hasPermissionTo('noticias.criar') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                @if (isset($blogs) && $blogs->count() < $blogLimit)
                                                    <a href="{{route('admin.dashboard.blog.create')}}" class="mdi mdi-plus-circle me-1 btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table-sortable table table-centered table-nowrap table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="bs-checkbox">
                                                    <label><input name="btnSelectAll" type="checkbox"></label>
                                                </th>
                                                {{-- <th>Link</th> --}}
                                                <th>Título</th>
                                                <th>Categoria</th>
                                                <th>Sub Categoria</th>
                                                <th>Imagem</th>
                                                <th>Publicado</th>
                                                <th>Status</th>
                                                <th>Destaque</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>
    
                                        <tbody data-route="{{route('admin.dashboard.blog.sorting')}}">
                                            @foreach ($blogs as $key => $blog)
                                                @php
                                                    if ($blog->blog_category_id) {
                                                        $categoria = $blogCategory[$blog->blog_category_id] ?? 'Nenhuma categoria';
                                                    } 
                                                    \Carbon\Carbon::setLocale('pt_BR');
                                                    $dataFormatada = \Carbon\Carbon::parse($blog->date)->translatedFormat('d \d\e F \d\e Y');
                                                @endphp

                                                <tr data-code="{{$blog->id}}">
                                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$blog->id}}"></label>
                                                    </td>
                                                    <td>{{substr(strip_tags($blog->title), 0, 40)}}...</td>
                                                    <td>{{$categoria}}</td>
                                                    <td>{{isset($blog->subcategory->name)?$blog->subcategory->name:"Nenhuma sub categoria"}}</td>
                                                    <td class="table-user text-center">
                                                        @if ($blog->path_image_thumbnail)
                                                            <img src="{{ asset('storage/'.$blog->path_image_thumbnail) }}" name="path_image_thumbnail" alt="table-user" class="me-2 rounded-circle">
                                                        @endif
                                                    </td>
                                                    <td>{{$dataFormatada}}</td>
                                                    <td class="text-center">
                                                        @switch($blog->active)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="text-center">
                                                        @switch($blog->highlight)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        @if (Auth::user()->hasPermissionTo('noticias.visualizar') &&
                                                        Auth::user()->hasPermissionTo('noticias.editar') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <a href="{{route('admin.dashboard.blog.edit', ['blog' => $blog->id])}}" class="mdi mdi-pencil table-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"></a>
                                                        @endif

                                                        @if (Auth::user()->hasPermissionTo('noticias.visualizar') &&
                                                        Auth::user()->hasPermissionTo('noticias.remover') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <form action="{{route('admin.dashboard.blog.destroy',['blog' => $blog->id])}}" style="width: 30px" method="POST">
                                                                @method('DELETE') @csrf        
                                                                
                                                                <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                                            </form>                                                    
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                   {{-- {{$blog->links()}} --}}
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
