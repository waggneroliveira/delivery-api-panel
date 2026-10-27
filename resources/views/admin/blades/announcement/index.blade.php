@extends('admin.core.admin')
@section('content')
<style>
    .btn-group.focus-btn-group{
        display: none;
    }
</style>
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
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('dashboard.title_dashboard')}}</a></li>
                                <li class="breadcrumb-item active">Anuncios</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Anuncios</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-12 d-flex justify-between">
                                    <div class="col-6">
                                        @if(Auth::user()->hasRole('Super') || 
                                        Auth::user()->can('usuario.tornar usuario master') || 
                                        Auth::user()->can('anuncio.visualizar') &&
                                        Auth::user()->can('anuncio.criar'))
                                            <button id="btSubmitDelete" data-route="{{route('admin.dashboard.announcement.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                        @endif
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        @if (Auth::user()->hasRole('Super') || 
                                        Auth::user()->can('usuario.tornar usuario master') || 
                                        Auth::user()->can('anuncio.visualizar') &&
                                        Auth::user()->can('anuncio.criar'))
                                            <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#announcement-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="announcement-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="announcement modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body p-2 px-3 px-md-4">
                                                            <form action="{{route('admin.dashboard.announcement.store')}}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @include('admin.blades.announcement.form', ['textareaId' => 'textarea-create'])  
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
                                    </div>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table-sortable table table-centered table-nowrap table-striped" id="products-datatable">
                                    <thead>                                        
                                        <tr>
                                            <th></th>
                                            <th class="bs-checkbox">
                                                <label><input name="btnSelectAll" type="checkbox"></label>
                                            </th>
                                            <th class="text-center">Exibição</th>
                                            <th class="text-center">Imagem Desktop</th>
                                            <th>{{__('dashboard.created_at')}}</th>
                                            <th>{{__('dashboard.status')}}</th>
                                            <th style="width: 85px;">{{__('dashboard.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody data-route="{{route('admin.dashboard.announcement.sorting')}}">
                                        @foreach($announcements as $key => $announcement)
                                            <tr data-code="{{$announcement->id}}">
                                                <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox">
                                                    <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$announcement->id}}"></label>
                                                </td>
                                                <td class="text-center text-capitalize">
                                                    {{$announcement->exhibition}}
                                                </td>
                                                <td class="table-announcement text-center">
                                                    @if ($announcement->path_image)
                                                        <img src="{{ asset('storage/'.$announcement->path_image) }}" alt="table-announcement" class="me-2 rounded-circle" style="width: 40px; height: 40px;">
                                                        @else      
                                                        <img src="{{asset('build/admin/images/announcements/announcement-3.jpg')}}" alt="table-announcement" class="me-2 rounded-circle">
                                                    @endif
                                                </td>                                                   
                                                <td>
                                                    @php
                                                        $locales = [
                                                            'pt' => 'd/m/Y H:i:s',
                                                            'en' => 'Y-m-d H:i A',          
                                                            'es' => 'Y-m-d H:i A',          

                                                        ];
                                                        $locale = session()->get('locale');
                                                    @endphp
                                                        @if ($announcement && $announcement->created_at)
                                                            @if (array_key_exists($locale, $locales))
                                                                {{$announcement->created_at->format($locales[$locale])}}
                                                                @else
                                                                {{$announcement->created_at->format('d/m/Y H:i:s')}}
                                                            @endif
                                                            @else
                                                            -
                                                        @endif
                                                </td>
                                                <td>
                                                    @switch($announcement->active)
                                                        @case(0) <span class="badge bg-soft text-danger">{{__('dashboard.inactive')}}</span> @break
                                                        @case(1) <span class="badge bg-soft-success text-success">{{__('dashboard.active')}}</span>@break
                                                    @endswitch                                                    
                                                </td>
            
                                                <td class="d-flex gap-lg-1 justify-center" style="padding: 18px 15px 0px 0px;">
                                                    @if (Auth::user()->hasRole('Super') || 
                                                    Auth::user()->can('usuario.tornar usuario master') || 
                                                    Auth::user()->can('anuncio.visualizar') &&
                                                    Auth::user()->can('anuncio.editar')) 
                                                        <button data-bs-toggle="modal" data-bs-target="#announcement-edit-{{$announcement->id}}" class="tabledit-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                        <div class="modal fade" id="announcement-edit-{{$announcement->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="announcement modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_edit')}}</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                    </div>
                                                                    <div class="modal-body p-2 px-3 px-md-4">
                                                                        <form action="{{ route('admin.dashboard.announcement.update', ['announcement' => $announcement->id]) }}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            @include('admin.blades.announcement.form')   
                                                                            <div class="d-flex justify-content-end gap-2">
                                                                                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
                                                                                <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_save')}}</button>
                                                                            </div>                                                                                                                      
                                                                        </form>                                                                    
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->
                                                    @endif
                                                    @if (Auth::user()->hasRole('Super') || 
                                                    Auth::user()->can('usuario.tornar usuario master') || 
                                                    Auth::user()->can('anuncio.visualizar') &&
                                                    Auth::user()->can('anuncio.remover'))
                                                        <form action="{{route('admin.dashboard.announcement.destroy',['announcement' => $announcement->id])}}" style="width: 30px" method="POST">
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
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
</div>
@endsection
