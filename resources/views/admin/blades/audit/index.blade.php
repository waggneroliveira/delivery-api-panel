@php
    // use App\Enums\ModelTypeAudit;
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
                                    <li class="breadcrumb-item active">{{__('blades/audit.title_audit')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{__('blades/audit.title_audit')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table-sortable table table-centered table-nowrap table-striped">
                                    <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>{{__('blades/audit.action_taken')}}</th>
                                        <th>{{__('blades/audit.date_event')}}</th>
                                        <th>{{__('blades/audit.manipulated_resource')}}</th>
                                        <th>{{__('blades/audit.manipulative_user')}}</th>
                                        <th>{{__('dashboard.action')}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($activities as $key => $activitie)
                                        <tr>
                                            <td></td>
                                            <td>
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
                                                
                                                @switch($activitie->description)
                                                    @case('login')
                                                        @if (isset($locale) || isset($locales))                                                            
                                                            @if (array_key_exists($locale, $locales))
                                                                <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                                                @else
                                                                {{$activitie->created_at->format('d/m/Y H:i:s')}}                                                                
                                                            @endif 
                                                        @endif
                                                    @break
                                                    @case('logout')
                                                        @if (isset($locale) || isset($locales))                                                            
                                                            @if (array_key_exists($locale, $locales))
                                                                <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                                                @else
                                                                {{$activitie->created_at->format('d/m/Y H:i:s')}}                                                                
                                                            @endif 
                                                        @endif
                                                    @break
                                                    @case('created')
                                                        @if (isset($locale) || isset($locales))                                                            
                                                            @if (array_key_exists($locale, $locales))
                                                                <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                                                @else
                                                                {{$activitie->created_at->format('d/m/Y H:i:s')}}                                                                
                                                            @endif 
                                                        @endif
                                                    @break
                                                    @case('updated')
                                                        @if (isset($locale) || isset($locales))                                                            
                                                            @if (array_key_exists($locale, $locales))
                                                                <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                                                @else
                                                                {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                                            @endif 
                                                        @endif
                                                    @break
                                                    @case('deleted')
                                                        @if (isset($locale) || isset($locales))                                                            
                                                            @if (array_key_exists($locale, $locales))
                                                                <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                                                @else
                                                                {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                                            @endif 
                                                        @endif
                                                    @break
                                                    @case('order_updated')
                                                        @if (isset($locale) || isset($locales))                                                            
                                                            @if (array_key_exists($locale, $locales))
                                                                <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                                                @else
                                                                {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                                            @endif 
                                                        @endif
                                                    @break
                                                    @case('multiple_deleted')
                                                        @if (isset($locale) || isset($locales))                                                            
                                                            @if (array_key_exists($locale, $locales))
                                                                <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                                                @else
                                                                {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                                            @endif 
                                                        @endif
                                                    @break
                                                    @case('test_conection_smtp')
                                                        @if (isset($locale) || isset($locales))                                                            
                                                            @if (array_key_exists($locale, $locales))
                                                                <span>{{$activitie->created_at->format($locales[$locale])}}</span>
                                                                @else
                                                                {{$activitie->created_at->format('d/m/Y H:i:s')}}
                                                            @endif 
                                                        @endif
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                {{$modelName = AuditActivity::getModelName($activitie->subject_type)}}
                                            </td>
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
                                                <td>{{isset($locale) && isset($locales)?$locales[$locale]:'Sistema'}}</td>
                                            @endif
                                            @if(Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can('auditoria.visualizar'))
                                                <td>
                                                    <a href="{{route('admin.dashboard.audit.show',['activitie' => $activitie->id])}}"
                                                    class="btn-icon mdi mdi-eye-outline"></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                    {{$activities->links()}}
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
@endsection
