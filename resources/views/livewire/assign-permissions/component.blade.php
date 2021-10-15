<div>
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">{{ $pageTitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">Home</a></li>
                      <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Buttons -->
            <div class="form-row  d-flex justify-content-end">
                <div class="form-group col-md-3">
                    <label class="sr-only" for="selectRole">Role</label>
                    <select wire:model="role_id" class="form-control" id="selectRole">
                        <option selected value="choose">Choose a Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    @can('assign_permissions_revoke_all')
                        <button type="button"
                            class="btn bg-gradient-primary btn-block shadow"
                            wire:click.prevent="revokeAll()"
                            title="Revoke all permissions">
                            <i class="fas fa-door-closed"></i>
                            Revoke all
                            <i wire:loading wire:target="revokeAll" class="fas fa-spinner fa-spin"></i>
                        </button>
                    @endcan
                </div>
                <div class="form-group col-md-3">
                    @can('assign_permissions_sync')
                        <button type="button"
                            class="btn bg-gradient-danger btn-block shadow"
                            wire:click.prevent="syncAll()">
                            <i class="fas fa-door-open"></i>
                                Sync all
                            <i wire:loading wire:target="syncAll" class="fas fa-spinner fa-spin"></i>
                        </button>
                    @endcan
                </div>
            </div>


            <!--Datatable -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gradient-primary">
                            <h3 class="card-title">Assigned permissions</h3>
                            <div class="card-tools">

                                <!-- Datatable's filters -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm m-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect02">Show</label>
                                            </div>
                                            <select wire:model="paginate" wire:change="resetPagination" class="custom-select" id="inputGroupSelect02">
                                                <option disabled>Choose...</option>
                                                <option value="10">10 items</option>
                                                <option selected value="25">25 items</option>
                                                <option selected value="50">50 items</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @include('common.search')
                                    </div>
                                </div>
                                <!-- /.Datatable filters -->

                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed table-hover">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th wire:click="order('name')">
                                            Permission
                                            @if($sort == 'name')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                            @if($this->role_id == 'choose')
                                                <span class="float-right text-sm mr-2 text-muted">
                                                    Please, select a role
                                                </span>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $permission)
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="font-weight-light">
                                                        {{ $permission->name }}
                                                    </p>
                                                    <p class="d-flex flex-row  text-right text-nowrap mb-0">
                                                        <span>
                                                            <label>
                                                                <input  @cannot('assign_permissions_sync') disabled @endcannot
                                                                    @if($this->role_id == 'choose') disabled @endif
                                                                    type="checkbox"
                                                                    id="p{{ $permission->id }}"
                                                                    wire:change="syncPermission($('#p' + {{ $permission->id }}).is(':checked'), '{{$permission->name}}' )"
                                                                    value="{{ $permission->id }}"
                                                                    class="new-control-input"
                                                                    {{ $permission->checked == 1 ? 'checked' : '' }}
                                                                >
                                                            </label>
                                                        </span>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- COMMENT: Muestra cuando el componente esta readyToLoad. Cunado el componente por naturaleza no mostrará grandes cantidades de registros, se puede evitar esta validación -->
                                        @if($readyToLoad == true)
                                            <tr>
                                                <td>
                                                    @if(strlen($search) <= 0)
                                                    <!-- COMMENT: Muestra 'Empty' cuando no items en la DB-->
                                                        <div class="col-12 d-flex justify-content-center align-items-center text-muted">
                                                            <p>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                </svg>
                                                            </p>
                                                            <p class="display-4">
                                                                Empty
                                                            </p>
                                                        </div>
                                                    @else
                                                    <!-- COMMENT: Muestra 'No results' cuando no hay resultados en una búsqueda -->
                                                        <div class="col-12 d-flex justify-content-center align-items-center text-muted">
                                                            <p>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                                                </svg>
                                                            </p>
                                                            <p>
                                                                There Aren’t Any Great Matches for Your Search: <b>'{{$search}}'
                                                            </p>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- COMMENT: Muestra sppiner cuando el componente no está readyToLoad -->
                            <div class="d-flex justify-content-center">
                                <p wire:loading wire:target="loadItems" class="display-4 text-muted pt-3"><i class="fas fa-fw fa-spinner fa-spin"></i></p>
                            </div>

                            @if(count($permissions))
                                <div class="ml-4">
                                    @if($permissions->hasPages())
                                        {{ $permissions->links() }}
                                    @endif
                                </div>
                            @endif
                        </div>
                          <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    {{--@include('livewire.role.form')--}}
</div>

<script type="text/javascript">
    window.addEventListener('assigned', event => {
        notify(event)
    });

    window.addEventListener('revoked', event => {
        notify(event)
    });

    window.addEventListener('error', event => {
        notify(event)
    });
</script>