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
                                <li class="breadcrumb-item active">Galeria de imagens</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Galeria de imagens</h4>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12 d-flex justify-between mb-2">
                    <div class="col-6">
                        @if (Auth::user()->can('representantes.visualizar') &&
                        Auth::user()->can('representantes.remover') ||
                        Auth::user()->can('usuario.tornar usuario master') || 
                        Auth::user()->hasRole('Super'))
                            <button id="btSubmitDelete" data-route="{{route('admin.dashboard.gallery.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                        @endif
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['serviceItem.visualizar', 'serviceItem.criar']))
                            @if (empty($serviceSection['gallery']))
                            
                                <button type="button" class="me-2 btn btn-secondary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#serviceItem-section-create"><i class="mdi mdi-plus-circle me-1"></i> Informações da sessão</button>
                                                                                <!-- Modal -->
                                <div class="modal fade" id="serviceItem-section-create" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1360px;">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light">
                                                <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <form action="{{route('admin.dashboard.serviceSection.store')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    
                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.sectionGallery.form", ['serviceSection', 'serviceItem', 'themeData'])
                                                    
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
                                    <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1360px;">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light">
                                                <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <form action="{{route('admin.dashboard.serviceSection.update', ['serviceSection' => $serviceSection['gallery']['id']])}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                
                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.sectionGallery.form", ['serviceSection', 'serviceItem', 'themeData'])
                                                    
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
                        <button class="table-edit-button btn btn-primary text-black col-5" data-bs-toggle="modal" data-bs-target="#modal-gellery-edit">
                            <i class="mdi mdi-plus-circle me-1"></i> Cadastrar imagens
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="modal-gellery-edit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h4 class="modal-title" id="myCenterModalLabel">
                                    <i class="mdi mdi-image-multiple me-2"></i>Galeria de Imagens
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            
                            <div class="modal-body p-4">
                                <form action="{{route('admin.dashboard.gallery.store')}}" 
                                    method="post" 
                                    enctype="multipart/form-data"
                                    id="galleryForm">
                                    
                                    @csrf
                                    @method('post')
                                    
                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.gallery.form", ['gallery', 'themeData'])
                                    
                                </form>                    
                            </div>
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
                                <th>Imagem</th>
                                <th style="width: 85px;">Ações</th>
                            </tr>
                        </thead>
                        
                        <tbody data-route="{{route('admin.dashboard.gallery.sorting')}}">
                            @foreach ($galleries as $key => $file)
                                <tr data-code="{{$file->id}}">
                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                    <td class="bs-checkbox">
                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$file->id}}"></label>
                                    </td>
                                    <td class="table-user text-center">
                                        @if ($file->file)
                                            <img src="{{ asset('storage/'.$file->file) }}" name="file" alt="table-user" class="me-2 rounded-circle">
                                        @endif
                                    </td>
                                    <td class="d-flex gap-lg-1 justify-center">
                                        <form action="{{route('admin.dashboard.gallery.destroy',['productGallery' => $file->id])}}" style="width: 30px" method="POST">
                                            @method('DELETE') @csrf        
                                            
                                            <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                        </form> 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection