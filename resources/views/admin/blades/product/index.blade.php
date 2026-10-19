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
                                    <li class="breadcrumb-item active">Produtos</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Produtos</h4>
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
                                        <form action="{{ route('admin.dashboard.product.index') }}" method="GET" class="mb-4">
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
                                                @if (isset($categories) && $categories->count()) 
                                                    <div class="col-md-2">
                                                        <label for="product_category_id" class="form-label">Categoria</label>
                                                        <select name="product_category_id" id="product_category_id" class="form-select">
                                                            <option value="">Todas</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" 
                                                                    {{ request('product_category_id') == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <!-- Botões -->
                                                <div class="col-md-3 d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary w-100 text-black">
                                                        <i class="bi bi-search text-black"></i> Filtrar
                                                    </button>

                                                    @if (request()->has('title') || request()->has('date') || request()->has('product_category_id'))
                                                        <a href="{{ route('admin.dashboard.product.index') }}" class="btn btn-outline-secondary w-100">
                                                            <i class="bi bi-x-circle"></i> Limpar
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 d-flex justify-between">
                                        <div class="col-6">
                                            @if (Auth::user()->hasPermissionTo('produtos.visualizar') &&
                                            Auth::user()->hasPermissionTo('produtos.remover') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <button id="btSubmitDelete" data-route="{{route('admin.dashboard.product.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                            @endif
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['produtos.visualizar', 'produtos.criar']))
                                                @if (empty($serviceSection['product']))
                                                
                                                    <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#serviceItem-section-create"><i class="mdi mdi-plus-circle me-1"></i> Informações da sessão</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="serviceItem-section-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>
                                                                <div class="modal-body p-4">
                                                                    <form action="{{route('admin.dashboard.serviceSection.store')}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        
                                                                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.productSection.form", ['textareaId' => 'textarea-create', 'serviceSection', 'serviceItem', 'themeData'])
                                                                        
                                                                        <div class="d-flex justify-content-end gap-2">
                                                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
                                                                            <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</button>
                                                                        </div>                                                 
                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                    @else
                                                    <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#serviceItem-section-edit"><i class="mdi mdi-plus-circle me-1"></i> Informações da sessão</button>
                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="serviceItem-section-edit" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>
                                                                <div class="modal-body p-4">
                                                                    <form action="{{route('admin.dashboard.serviceSection.update', ['serviceSection' => $serviceSection['product']['id']])}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                    
                                                                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.productSection.form", ['serviceSection', 'serviceItem', 'themeData'])
                                                                        
                                                                        <div class="d-flex justify-content-end gap-2">
                                                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
                                                                            <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</button>
                                                                        </div>                                                 
                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                @endif                                             
                                            @endif
                                            @if (Auth::user()->hasPermissionTo('produtos.visualizar') &&
                                            Auth::user()->hasPermissionTo('produtos.criar') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <a href="{{route('admin.dashboard.product.create')}}" class="mdi mdi-plus-circle me-1 btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</a>
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
                                                @if (isset($categories) && $categories->count())                                                    
                                                    <th>Categoria</th>
                                                @endif
                                                <th>Imagem</th>
                                                <th>Publicado</th>
                                                <th>Status</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>
    
                                        <tbody data-route="{{route('admin.dashboard.product.sorting')}}">
                                            @foreach ($products as $key => $product)
                                                @php
                                                    if ($product->product_category_id) {
                                                        $categoria = $productCategory[$product->product_category_id] ?? 'Nenhuma categoria';
                                                    } 
                                                    \Carbon\Carbon::setLocale('pt_BR');
                                                    $dataFormatada = \Carbon\Carbon::parse($product->date)->translatedFormat('d \d\e F \d\e Y');
                                                @endphp

                                                <tr data-code="{{$product->id}}">
                                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$product->id}}"></label>
                                                    </td>
                                                    <td>{{substr(strip_tags($product->title), 0, 40)}}...</td>
                                                    @if ($product->product_category_id)                                                        
                                                        <td>{{$categoria}}</td>
                                                    @endif
                                                    <td class="table-user text-center">
                                                        @if ($product->path_image_thumbnail)
                                                            <img src="{{ asset('storage/'.$product->path_image_thumbnail) }}" name="path_image_thumbnail" alt="table-user" class="me-2 rounded-circle">
                                                        @endif
                                                    </td>
                                                    <td>{{$dataFormatada}}</td>
                                                    <td class="text-center">
                                                        @switch($product->active)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        @if (Auth::user()->hasPermissionTo('produtos.visualizar') &&
                                                        Auth::user()->hasPermissionTo('produtos.editar') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <a href="{{route('admin.dashboard.product.edit', ['product' => $product->id])}}" class="mdi mdi-pencil table-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"></a>
                                                        @endif

                                                        @if (Auth::user()->hasPermissionTo('produtos.visualizar') &&
                                                        Auth::user()->hasPermissionTo('produtos.remover') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <form action="{{route('admin.dashboard.product.destroy',['product' => $product->id])}}" style="width: 30px" method="POST">
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
                                   {{-- {{$product->links()}} --}}
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
