@extends('admin.core.admin')
@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row col-12">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('dashboard.title_dashboard')}}</a></li>
                                <li class="breadcrumb-item active"><a href="{{route('admin.dashboard.group.index')}}">{{__('dashboard.group_and_permission')}}</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">{{__('dashboard.btn_edit')}}</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 
            <div class="row col-12">
                <div class="col-12 col-lg-12">
                    <div class="card card-body">
                        @include('admin.blades.group.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection