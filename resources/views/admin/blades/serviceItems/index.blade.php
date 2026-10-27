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
                                <li class="breadcrumb-item active">Serviços</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Serviços</h4>
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
                                        @if(Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['servicos.visualizar', 'servicos.remover']))
                                            <button id="btSubmitDelete" data-route="{{route('admin.dashboard.serviceItem.destroySelected')}}" type="button" class="btSubmitDelete btn btn-danger" style="display: none;">{{__('dashboard.btn_delete_all')}}</button>
                                        @endif
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['servicos.visualizar', 'servicos.criar']))
                                            @if (empty($serviceSection['service']))
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
                                                                
                                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.serviceSection.form", ['serviceSection', 'serviceItem', 'themeData'])
                                                                    
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
                                                                <form action="{{route('admin.dashboard.serviceSection.update', ['serviceSection' => $serviceSection['service']['id']])}}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                
                                                                    @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.serviceSection.form", ['serviceSection', 'serviceItem', 'themeData'])
                                                                    
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

                                        @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['servicos.visualizar', 'servicos.criar']))
                                            @if (is_null($serviceItemLimit) || $serviceItems->count() < $serviceItemLimit)
                                                <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#serviceItem-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create') . ' Serviços'}} </button>
                                            @endif    
                                            <!-- Modal -->
                                            <div class="modal fade" id="serviceItem-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="serviceItem modal-dialog modal-dialog-centered" style="max-width: 1360px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <form action="{{route('admin.dashboard.serviceItem.store')}}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                               
                                                                @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.serviceItems.form", ['textareaId' => 'textarea-create', 'serviceItem', 'themeData'])
                                                                
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
                                            <th>Título</th>
                                            <th>Ícone</th>
                                            <th>{{__('dashboard.created_at')}}</th>
                                            <th>{{__('dashboard.status')}}</th>
                                            <th style="width: 85px;">{{__('dashboard.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody data-route="{{route('admin.dashboard.serviceItem.sorting')}}">
                                        @foreach($serviceItems as $key => $serviceItem)
                                            <tr data-code="{{$serviceItem->id}}">
                                                <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox">
                                                    <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$serviceItem->id}}"></label>
                                                </td>
                                                <td>
                                                   {!!isset($serviceItem->title)?$serviceItem->title:'-'!!}
                                                </td>
                                                <td class="table-serviceItem text-start">
                                                    @if ($serviceItem->path_icon)
                                                        <img src="{{ asset('storage/'.$serviceItem->path_icon) }}" alt="table-serviceItem" class="me-2 rounded-circle" style="width: 40px; height: 40px;">
                                                        @else    
                                                        -  
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
                                                        @if ($serviceItem && $serviceItem->created_at)
                                                            @if (array_key_exists($locale, $locales))
                                                                {{$serviceItem->created_at->format($locales[$locale])}}
                                                                @else
                                                                {{$serviceItem->created_at->format('d/m/Y H:i:s')}}
                                                            @endif
                                                            @else
                                                            -
                                                        @endif
                                                </td>
                                                <td>
                                                    @switch($serviceItem->active)
                                                        @case(0) <span class="badge bg-soft text-danger">{{__('dashboard.inactive')}}</span> @break
                                                        @case(1) <span class="badge bg-soft-success text-success">{{__('dashboard.active')}}</span>@break
                                                    @endswitch                                                    
                                                </td>
            
                                                <td class="d-flex gap-lg-1 justify-center" style="padding: 18px 15px 0px 0px;">
                                                    @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['servicos.visualizar', 'servicos.editar'])) 
                                                        <button data-bs-toggle="modal" data-bs-target="#serviceItem-edit-{{$serviceItem->id}}" class="tabledit-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                        <div class="modal fade" id="serviceItem-edit-{{$serviceItem->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="serviceItem modal-dialog modal-dialog-centered"  style="max-width: 1360px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_edit')}}</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                    </div>
                                                                    <div class="modal-body p-4">
                                                                        <form action="{{ route('admin.dashboard.serviceItem.update', ['serviceItem' => $serviceItem->id]) }}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')

                                                                            @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.serviceItems.form", ['serviceItem', 'themeData'])
                                                                            
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
                                                    @if (Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['servicos.visualizar', 'servicos.remover']))
                                                        <form action="{{route('admin.dashboard.serviceItem.destroy',['serviceItem' => $serviceItem->id])}}" style="width: 30px" method="POST">
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
