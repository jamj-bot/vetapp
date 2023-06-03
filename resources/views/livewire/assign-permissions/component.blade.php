<div wire:init="loadItems()">
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">{{ $pageTitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index')}}"><i class="fas fa-house-user"></i></a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $pageTitle }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!--Datatable -->
            <div class="row">
                <div class="col-12">
                    <!-- Datatable's filters when screen < md-->
                    @include('common.datatable-filters-smaller-md')

                    <div class="row p-0 d-md-none mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="sr-only" for="selectRole">Role</label>
                                <select wire:model="role_id" class="custom-select custom-select-md form-control-border" id="selectRole">
                                    <option disabled selected value="choose">Select a Role...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Datatable's filters when screen > md-->
                    @include('common.datatable-filters-wider-md')

                    <div class="row d-none d-md-block">
                        <div class="col-12">
                            <div class="form-row d-flex justify-content-start">
                                <div class="form-group col-md-3">
                                    <label class="sr-only" for="selectRole">Role</label>
                                    <select wire:model="role_id" class="custom-select custom-select-md form-control-border" id="selectRole">
                                        <option disabled selected value="choose">Select a Role...</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="card">
                        <div class="card-header bg-gradient-maroon">
                            <h3 class="card-title">Assign permissions</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed table-hover text-sm">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>
                                             <div class="icheck-wisteria" >
                                                <input type="checkbox"
                                                id="select_page"
                                                wire:model="select_page"
                                                {{-- wire:change.prevent="syncAll()" --}}
                                                wire:loading.attr="disabled"
                                                @if($this->role_id == 'choose') disabled @endif>
                                                <label class="sr-only" for="select_page">Click to check all items</label>
                                            </div>
                                        </th>
                                        <th wire:click="order('name')" class="">
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
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $permission)
                                        <tr>
                                            <td width="10px">
                                                @can('assign_permissions_sync')
                                                    <div class="icheck-wisteria">
                                                        <input type="checkbox"
                                                            @if($this->role_id == 'choose') disabled @endif
                                                            id="p{{ $permission->id }}"
                                                            wire:change="syncPermission($('#p' + {{ $permission->id }}).is(':checked'), '{{$permission->name}}' )"
                                                            value="{{$permission->id}}"
                                                            {{ $permission->checked == 1 ? 'checked' : '' }}>
                                                        <label class="sr-only" for="p{{$permission->id}}">{{ $this->role_id == 'choose' ? 'Please, select a role' : 'Click to Assign permission / Revoke permission' }}
                                                        </label>
                                                    </div>
                                                @endcan
                                            </td>
                                            <td class="">
                                                {{ Str::of(str_replace('_', ' ', $permission->name))->title() }}



{{--                                                         <p class="d-flex flex-row  text-right text-nowrap mb-0">
                                                            <span>
                                                                <label>
                                                                    <code>[{{ $permission->name }}]</code>
                                                                    <input
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
                                                        </p> --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- COMMENT: Muestra cuando el componente esta readyToLoad -->
                                        @if($readyToLoad == true)
                                            <tr>
                                                <td colspan="2">
                                                    @include('common.datatable-feedback')
                                                </td>
                                            </tr>
                                        @endif
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- COMMENT: Muestra sppiner cuando el componente no está readyToLoad -->
                            <div class="d-flex justify-content-center">
                                <p wire:loading wire:target="loadItems" class="display-4 text-muted pt-3">
                                    <span class="loader"></span>
                                </p>
                            </div>
                        </div>
                          <!-- /.card-body -->

                        <!-- card-footer -->
                        @if(count($permissions))
                            @if($permissions->hasPages())
                                <div class="card-footer clearfix" style="display: block;">
                                    <div class="mailbox-controls">
                                        <div class="float-right pagination pagination-sm">
                                            <div class="ml-4">
                                                {{ $permissions->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <!-- /.card-footer -->

                        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
                        <div wire:loading.class="overlay dark" wire:target="store, update, destroy">
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    {{--@include('livewire.role.form')--}}
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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