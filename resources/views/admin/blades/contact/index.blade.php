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
                                <li class="breadcrumb-item active">Contato</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Contato</h4>
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
                                        @if (Auth::user()->hasRole('Super') || 
                                        Auth::user()->can('usuario.tornar usuario master') || 
                                        Auth::user()->can('contato.visualizar') &&
                                        Auth::user()->can('contato.criar'))
                                            @if (empty($contact))                                            
                                                <button type="button" class="btn btn-primary text-black waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#contact-create"><i class="mdi mdi-plus-circle me-1"></i> {{__('dashboard.btn_create')}}</button>
                                            @endif
                                            <!-- Modal -->
                                            <div class="modal fade" id="contact-create" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="contact modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_create')}}</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body p-2 px-3 px-md-4">
                                                            <form action="{{route('admin.dashboard.contact.store')}}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                
                                                                @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.contact.form", ['textareaId' => 'textarea-create', 'contact', 'themeData'])

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
                                            <th>Título da sessão</th>
                                            <th>{{__('dashboard.created_at')}}</th>
                                            <th style="width: 85px;">{{__('dashboard.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($contact))                                            
                                            <tr>
                                                <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td>{{isset($contact->name_section)?$contact->name_section:''}}</td>                                  
                                                <td>
                                                    @php
                                                        $locales = [
                                                            'pt' => 'd/m/Y H:i:s',
                                                            'en' => 'Y-m-d H:i A',          
                                                            'es' => 'Y-m-d H:i A',          

                                                        ];
                                                        $locale = session()->get('locale');
                                                    @endphp
                                                        @if ($contact && $contact->created_at)
                                                            @if (array_key_exists($locale, $locales))
                                                                {{$contact->created_at->format($locales[$locale])}}
                                                                @else
                                                                {{$contact->created_at->format('d/m/Y H:i:s')}}
                                                            @endif
                                                            @else
                                                            -
                                                        @endif
                                                </td>
            
                                                <td class="d-flex gap-lg-1 justify-center" style="padding: 18px 15px 0px 0px;">
                                                    @if (Auth::user()->hasRole('Super') || 
                                                    Auth::user()->can('usuario.tornar usuario master') || 
                                                    Auth::user()->can('contato.visualizar') &&
                                                    Auth::user()->can('contato.editar')) 
                                                        <button data-bs-toggle="modal" data-bs-target="#contact-edit-{{$contact->id}}" class="tabledit-edit-button btn btn-primary text-black" style="padding: 2px 8px;width: 30px"><span class="mdi mdi-pencil"></span></button>
                                                        <div class="modal fade" id="contact-edit-{{$contact->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="contact modal-dialog modal-dialog-centered" style="max-width: 1260px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <h4 class="modal-title" id="myCenterModalLabel">{{__('dashboard.btn_edit')}}</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                    </div>
                                                                    <div class="modal-body p-2 px-3 px-md-4">
                                                                        <form action="{{ route('admin.dashboard.contact.update', ['contact' => $contact->id]) }}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            
                                                                            {{-- @include('admin.blades.contact.form', ['textareaId' => 'textarea-edit'])   --}}
                                                                            
                                                                            @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.contact.form", ['contact', 'themeData'])
  
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
                                                    Auth::user()->can('contato.visualizar') &&
                                                    Auth::user()->can('contato.remover'))
                                                        <form action="{{route('admin.dashboard.contact.destroy',['contact' => $contact->id])}}" style="width: 30px" method="POST">
                                                            @method('DELETE') @csrf        
                                                            
                                                            <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                                        </form>                                                    
                                                    @endif
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
