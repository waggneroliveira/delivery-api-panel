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
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('dashboard.title_dashboard')}}</a></li>
                                <li class="breadcrumb-item active"><a href="{{route('admin.dashboard.user.index')}}">{{__('dashboard.users')}}</a></li>
                                <li class="breadcrumb-item active">{{__('dashboard.profile')}}</li>
                            </ol>
                        </div>
                        <h4 class="page-title">{{__('dashboard.btn_edit')}}</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card card-body">
                        <form action="{{route('admin.dashboard.user.update', ['user' => $user->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            
                            @if ($currentRoles->isNotEmpty())
                                @foreach($currentRoles as $role)  
                                    <input type="hidden" name="roles[]" value="{{ $role->name }}">                    
                                @endforeach        
                            @endif

                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="name" class="form-label">{{__('blades/configEmail.user')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name{{isset($user->id)?$user->id:''}}" value="{{isset($user)?$user->name:''}}" placeholder="Digite seu nome" required>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="exampleInputEmail1" class="form-label">{{__('blades/configEmail.email')}} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{isset($user)?$user->email:''}}" class="form-control" id="exampleInputEmail1{{isset($user->id)?$user->id:''}}" placeholder="Digite seu email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="password" class="form-label">{{__('blades/configEmail.password')}} <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" id="password-{{ isset($user->id) ? $user->id : '' }}" class="form-control" placeholder="Digite sua senha" {{ !isset($user) ? 'required' : '' }}>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3 d-flex align-items-center">
                                    <div class="form-check">
                                        <input name="active" {{ isset($user->active) && $user->active == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" id="invalidCheck{{isset($user->id)?$user->id:''}}" />
                                        <label class="form-check-label" for="invalidCheck{{isset($user->id)?$user->id:''}}">{{__('dashboard.active')}}?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <input type="file" name="path_image" data-plugins="dropify" data-default-file="{{ isset($user) && $user->path_image != '' ? url('storage/'.$user->path_image) : '' }}"  />
                                    <p class="text-muted text-center mt-2 mb-0">{{__('dashboard.text_img_size')}} <b class="text-danger">2 MB</b>.</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('admin.dashboard.user.index')}}" class="btn btn-danger waves-effect waves-light">{{__('dashboard.btn_cancel')}}</a>
                                <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection