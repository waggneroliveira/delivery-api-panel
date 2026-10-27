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
                                    <li class="breadcrumb-item active">Sobre</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Sobre</h4>
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
                                            @if (Auth::user()->hasPermissionTo('sobre nos.visualizar') &&
                                            Auth::user()->hasPermissionTo('sobre nos.remover') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                <button id="btSubmitDelete" data-route="{{route('admin.dashboard.about.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                            @endif
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            @if (Auth::user()->hasPermissionTo('sobre nos.visualizar') &&
                                            Auth::user()->hasPermissionTo('sobre nos.criar') ||
                                            Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                            Auth::user()->hasRole('Super'))
                                                @if (isset($abouts) && $abouts->count() < $aboutLimit)                                                    
                                                    <a href="{{route('admin.dashboard.about.create')}}" class="mdi mdi-plus-circle me-1 btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</a>
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
                                                <th>Imagem</th>
                                                <th>Status</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>
                                        
                                        @foreach($abouts as $key => $about)                                            
                                            <tbody data-route="{{route('admin.dashboard.about.sorting')}}">
                                                @php
                                                    if ( $about->about_category_id) {
                                                        $categoria = $aboutCategory[$about->about_category_id] ?? 'Nenhuma categoria';
                                                    } 
                                                    \Carbon\Carbon::setLocale('pt_BR');
                                                    $dataFormatada = \Carbon\Carbon::parse($about->date)->translatedFormat('d \d\e F \d\e Y');
                                                @endphp

                                                <tr data-code="{{$about->id}}">
                                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="{{$about->id}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$about->id}}"></label>
                                                    </td>
                                                    <td>{{substr(strip_tags($about->title), 0, 40)}}...</td>
                                                    <td class="table-user text-start">
                                                        @if ($about->path_image)
                                                            <img src="{{ asset('storage/'.$about->path_image) }}" name="path_image" alt="table-user" class="me-2 rounded-circle">
                                                        @endif
                                                    </td>
                                                    <td class="text-start">
                                                        @switch($about->active)
                                                            @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                            @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @endswitch
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        @if (Auth::user()->hasPermissionTo('sobre nos.visualizar') &&
                                                        Auth::user()->hasPermissionTo('sobre nos.editar') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <a href="{{route('admin.dashboard.about.edit', ['about' => $about->id])}}" class="mdi mdi-pencil table-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"></a>
                                                        @endif

                                                        @if (Auth::user()->hasPermissionTo('sobre nos.visualizar') &&
                                                        Auth::user()->hasPermissionTo('sobre nos.remover') ||
                                                        Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                                                        Auth::user()->hasRole('Super'))
                                                            <form action="{{route('admin.dashboard.about.destroy',['about' => $about->id])}}" style="width: 30px" method="POST">
                                                                @method('DELETE') @csrf        
                                                                
                                                                <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                                            </form>                                                    
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach                                           
                                        
                                    </table>
                                </div>

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                   {{-- {{$about->links()}} --}}
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
