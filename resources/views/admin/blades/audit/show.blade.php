@php
    use App\Enums\ModelTypeAudit;
    use App\Models\AuditActivity;
@endphp
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
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('dashboard.title_dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard.audit.index')}}">{{__('blades/audit.title_audit')}}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('blades/audit.view_audit')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{__('blades/audit.view_audit')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="card card-body">
                    <div class="mb-2 col-lg-6">
                        <div>
                            <h5>{{__('blades/audit.manipulative_user')}}</h5>
                        </div>
                        @if($activitie->causer)
                            <!-- Verifica se há um usuário associado (causer) -->
                            <td>{{ $activitie->causer->name }}</td>
                        @else
                            @php
                                $locales = [
                                    'pt' => 'Sistema',
                                    'en' => 'System',          
                                    'es' => 'Sistema',          

                                ];
                                $locale = session()->get('locale');
                            @endphp
                            <td>{{isset($locale)?$locales[$locale]:'Sistema'}}</td>
                        @endif
                    </div>
                    <div class="mb-2 col-lg-6">
                        <div>
                            <h5>{{__('blades/audit.manipulated_resource')}}</h5>
                        </div>
                        {{$modelName = AuditActivity::getModelName($activitie->subject_type)}}
                    </div>
                    <div class="mb-2">
                        <div>
                            <h5>{{__('blades/audit.action_taken')}}</h5>
                        </div>
                        @switch($activitie->description)
                            @case('login') <span>Login</span> @break
                            @case('logout') <span>Logout</span> @break
                            @case('created') <span>{{__('blades/audit.action_audit_create')}}</span> @break
                            @case('updated') <span>{{__('blades/audit.action_audit_update')}}</span> @break
                            @case('deleted') <span>{{__('blades/audit.action_audit_deleted')}}</span> @break
                            @case('order_updated') <span>{{__('blades/audit.action_audit_order_updated')}}</span> @break
                            @case('multiple_deleted') <span>{{__('blades/audit.action_audit_multiple_deleted')}}</span> @break
                            @case('test_conection_smtp') <span>{{__('blades/audit.action_audit_test_conection_smtp')}}</span> @break
                        @endswitch
                    </div>
                    <div class="mb-2">
                        <div>
                            <h5>{{__('blades/audit.date_event')}}</h5>
                        </div>
                        @php
                            $locales = [
                                'pt' => 'd/m/Y H:i:s',
                                'en' => 'Y-m-d H:i A',          
                                'es' => 'Y-m-d H:i A',          

                            ];
                            $locale = session()->get('locale');
                        @endphp
                        
                        @switch($activitie->description)
                            @case('login')
                                @if (array_key_exists($locale, $locales))
                                    <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                    @else
                                    {{$activitie->created_at->format('d/m/Y H:i:s')}}   
                                @endif 

                            @break
                            @case('logout')
                                @if (array_key_exists($locale, $locales))
                                    <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                    @else
                                    {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                @endif 
                            @break
                            @case('created')
                                @if (array_key_exists($locale, $locales))
                                    <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                    @else
                                    {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                @endif 
                            @break
                            @case('updated')
                                @if (array_key_exists($locale, $locales))
                                    <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                    @else
                                    {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                @endif 
                            @break
                            @case('deleted')
                                @if (array_key_exists($locale, $locales))
                                    <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                    @else
                                    {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                @endif 
                            @break
                            @case('order_updated')
                                @if (array_key_exists($locale, $locales))
                                    <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                    @else
                                    {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                @endif 
                            @break
                            @case('multiple_deleted')
                                @if (array_key_exists($locale, $locales))
                                    <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                    @else
                                    {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                @endif 
                            @break
                            @case('test_conection_smtp')
                                @if (array_key_exists($locale, $locales))
                                    <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                    @else
                                    {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                @endif 
                            @break
                        @endswitch
                    </div>
                    <div class="mb-2">
                        <div>
                            <h5>{{__('blades/audit.old_value')}}</h5>
                        </div>
                        <code>
                            {{ print_r($activitie->properties['old'] ?? [], true) }}
                        </code>
                    </div>
                    <div class="mb-2">
                        <div>
                            <h5>{{__('blades/audit.new_value')}}</h5>
                        </div>
                        <code>
                            {{ print_r($activitie->properties['attributes'] ?? [], true) }}
                        </code>
                    </div>
                </div> <!-- end card-body-->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>
@endsection
