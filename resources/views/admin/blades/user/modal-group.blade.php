<div class="row">
    @if (!Auth::user()->hasRole('Super') && !Auth::user()->can('usuario.tornar usuario master') && !Auth::user()->can('usuario.atribuir grupos'))
        <span class="text-danger mt-0 mb-3"><i class="mdi mdi-alert-circle"></i> {{__('blades/group.not_permission')}}</span>
    @endif
    <input type="hidden" name="active" value="{{ isset($user->active) && $user->active == 1 ? 'on' : 'off' }}">

    @if ($user->currentRoles->isNotEmpty())
        <h5 class="page-title">{{__('blades/group.current_group')}}</h5>
        <div>
            <ul class="list-group w-100 h-25" style="column-count: 2">
                @foreach($user->currentRoles as $role)
                    <li class="list-group-item">
                        <label>
                            {{ ucfirst($role->name) }}
                        </label>
                        <input type="checkbox" name="roles[]" checked value="{{ $role->name }}" 
                            @if(Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can('usuario.atribuir grupos')) 
                            @else 
                                disabled 
                            @endif>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($user->otherRoles->isNotEmpty())
        <div>
            <ul class="list-group w-100 h-25" style="column-count: 2">
                <div class="mt-2">
                    <h5 class="page-title">{{__('blades/group.add_group')}}</h5>

                    @foreach($user->otherRoles as $role)
                        <li class="list-group-item">
                            <label>
                                {{ ucfirst($role->name) }}
                            </label>
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                @if(Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can('usuario.atribuir grupos')) 
                                @else 
                                    disabled 
                                @endif>
                        </li>
                    @endforeach
                </div>
            </ul>
        </div>
    @endif

</div>

@if (Auth::user()->hasPermissionTo('usuario.atribuir grupos') ||
Auth::user()->hasPermissionTo('usuario.tornar usuario master') ||
Auth::user()->hasRole('Super'))   
    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
        <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_create')}}</button>
    </div>
@endif


