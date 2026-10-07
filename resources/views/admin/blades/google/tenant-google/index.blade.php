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
                                <li class="breadcrumb-item active">Cliente Cadastrado no Google Console</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Cliente Cadastrado no Google Console</h4>
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
                                    <div class="col-12 d-flex justify-content-end">
                                        @if (!$tenantGoogle)                                            
                                            <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#tenantGoogle-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                        @endif
                                        <!-- Modal -->
                                        <div class="modal fade" id="tenantGoogle-create" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="tenantGoogle modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body p-2 px-3 px-md-4">
                                                        <form action="{{route('google.search-console.client.store')}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            
                                                            @include('admin.blades.google.tenant-google.form')

                                                            <div class="d-flex justify-content-end gap-2">
                                                                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
                                                                <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</button>
                                                            </div>                                                 
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->                                        
                                    </div>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table-sortable table table-centered table-nowrap table-striped" id="products-datatable">
                                    <thead>                                        
                                        <tr>
                                            <th></th>
                                            <th>Cliente</th>
                                            <th>Propriedade</th>
                                            <th>{{__('dashboard.status')}}</th>
                                            <th style="width: 85px;">{{__('dashboard.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($tenantGoogle) && $tenantGoogle <> null)                                                                                    
                                            <tr>
                                                <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td>{{isset($tenantGoogle)?$tenantGoogle->tenant->name:''}}</td>     
                                                <td>{{isset($tenantGoogle->property)?$tenantGoogle->property:''}}</td>    
                                                <td>
                                                    @switch($tenantGoogle->active)
                                                        @case(0) <span class="badge bg-soft text-danger">{{__('dashboard.inactive')}}</span> @break
                                                        @case(1) <span class="badge bg-soft-success text-success">{{__('dashboard.active')}}</span>@break
                                                    @endswitch                                                    
                                                </td>                              
                                                           
                                                <td class="d-flex gap-lg-1 justify-center" style="padding: 18px 15px 0px 0px;">
                                                    <button data-bs-toggle="modal" data-bs-target="#tenantGoogle-edit-{{$tenantGoogle->id}}" class="tabledit-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                    <div class="modal fade" id="tenantGoogle-edit-{{$tenantGoogle->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="tenantGoogle modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_edit')}}</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>
                                                                <div class="modal-body p-2 px-3 px-md-4">
                                                                    <form action="{{ route('google.search-console.client.update', ['tenantGoogleSearchConsole' => $tenantGoogle->id]) }}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        
                                                                        @include('admin.blades.google.tenant-google.form')

                                                                        <div class="d-flex justify-content-end gap-2">
                                                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
                                                                            <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_save')}}</button>
                                                                        </div>                                                                                                                      
                                                                    </form>                                                                    
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

                                                    <form action="{{route('google.search-console.client.destroy',['tenantGoogleSearchConsole' => $tenantGoogle->id])}}" style="width: 30px" method="POST">
                                                        @method('DELETE') @csrf        

                                                        <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                                    </form>  
                                                </td>
                                            </tr>
                                        @endif  
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
