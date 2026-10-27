<div class="mb-3">
    <label for="name" class="form-label">{{__('blades/group.name_of_group')}}</label>
    <input type="text" name="name" required class="form-control" id="name{{isset($group->id)?$group->id:''}}" value="{{isset($group)?$group->name:''}}" placeholder="Digite o nome do grupo">
</div>
<div class="text-end">
    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">{{__('dashboard.btn_cancel')}}</button>
    <button type="submit" class="btn btn-success waves-effect waves-light">{{__('dashboard.btn_save')}}</button>
</div>
@if ($permissions->count())
    <div class="row mt-3">
        <ul class="permissions-group" style="border:1px solid #424e5a; list-style: none; margin: 0; padding: 1rem;">
            @php
                $last_index = '';
            @endphp
            @foreach($permissions as $permission)
                @if($last_index !== $permission->index())
                    @if($last_index !== '')
                        </ul> <!-- fecha a lista anterior -->
                    </li> <!-- fecha o último item -->
                    @endif
                    <li class="permission-category" style="box-sizing: border-box; padding: 0 1rem 1rem 0;">
                        <strong>{{ ucfirst($permission->index()) }}:</strong>
                        <ul class="permission-list pl-3 list-unstyled" style="margin-top: 0.5rem; padding-left: 1rem;">
                @endif

                @if(Auth::user()->hasRole('Super') || Auth::user()->can('usuario.tornar usuario master') || Auth::user()->can(['grupo.visualizar', 'grupo.criar']))
                    <li>
                        <label>
                            <input name="permissions[]"
                                type="checkbox"
                                @if(isset($group) && $group->hasPermissionTo($permission->name)) checked @endif
                                value="{{ $permission->name }}">
                            {{ ucfirst($permission->name()) }}
                        </label>
                    </li>
                @elseif(Auth::user()->can(['grupo.visualizar', 'grupo.editar']))
                    <li>
                        <label>
                            <input name="permissions[]"
                                type="checkbox"
                                @if(isset($group) && $group->hasPermissionTo($permission->name)) checked @endif
                                value="{{ $permission->name }}">
                            {{ ucfirst($permission->name()) }}
                        </label>
                    </li>
                @endif

                @php
                    $last_index = $permission->index();
                @endphp
            @endforeach
            </ul> <!-- fecha a última lista -->
            </li> <!-- fecha o último item -->
        </ul> <!-- fecha o grupo -->
    </div>

    <style>
        .permissions-group {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 colunas no desktop */
            gap: 1rem;
        }

        /* Mobile: 2 colunas */
        @media (max-width: 768px) {
            .permissions-group {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .permission-category {
            /* Para cada categoria, adiciona espaçamento interno */
            padding-bottom: 1rem;
            border-bottom: 1px solid #ddd;
        }

        .permission-list {
            padding-left: 1rem;
            margin-top: 0.5rem;
        }

        .permission-list li label {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            max-width: 100%;
            white-space: normal;  
            overflow-wrap: break-word;
            line-height: 17px;
            margin-bottom: 5px;
        }

        .permission-list li input[type="checkbox"] {
            flex-shrink: 0;
        }
    </style>
@endif

