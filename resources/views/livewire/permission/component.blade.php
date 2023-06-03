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

                    <!-- Datatable's filters when screen > md-->
                    @include('common.datatable-filters-wider-md')

                    <!-- Datatable's buttons -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="col-auto">
                            @include('common.destroy-multiple-and-undo-buttons')
                        </div>

                        <div class="col-auto">
                            <!-- Add Button -->
                            @can('permissions_store')
                                @include('common.add-button')
                            @endcan
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-gradient-pink">
                            <h3 class="card-title">
                                @if($this->select_page)
                                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                                @else
                                    <span id="dynamicText{{$this->pageTitle}}">Permissions</span>
                                @endif
                            </h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- Datatable's when screen < md (card-body)-->
                        <div class="card-body table-responsive p-0 d-md-none">
                            <table class="table table-head-fixed table-hover text-sm">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>
                                            Name
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $permission)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                {{ $permission->name }}
                                            </td>
                                        </tr>
                                        <tr class="expandable-body d-none">
                                            <td colspan="1">
                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Associated roles</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        @foreach($permission->roles as $role)
                                                            <span class="text-uppercase badge bg-gradient-lime m-2 text-xs">
                                                                {{ $role->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold sr-only">Options</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span>
                                                            @can('permissions_update')
                                                                <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    wire:click.prevent="edit({{ $permission }})"
                                                                    title="Edit"
                                                                    class="btn btn-sm btn-link border border-0">
                                                                            <i class="fas fa-edit text-muted"></i>
                                                                    </a>
                                                            @endcan
                                                            @can('permissions_destroy')
                                                                <a href="javascript:void(0)"
                                                                    wire:click.prevent="destroy({{ $permission->id }})"
                                                                    title="Delete"
                                                                    class="btn btn-sm btn-link border border-0 icon">
                                                                        <i class="fas fa-trash text-muted"></i>
                                                                </a>
                                                            @endcan
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- COMMENT: Muestra cuando el componente esta readyToLoad -->
                                        @if($readyToLoad == true)
                                            <tr>
                                                <td colspan="1">
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
                                    {{-- <i class="fas fa-fw fa-spinner fa-spin"></i> --}}
                                    <span class="loader"></span>
                                </p>
                            </div>
                        </div>
                        <!-- /. Datatable's when screen < md (card-body) -->

                        <!-- Datatable's when screen > md (card-body) -->
                        <div class="card-body table-responsive p-0 d-none d-md-block">
                            <table class="table table-head-fixed table-hover text-sm datatable">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>
                                            <div class="icheck-amethyst">
                                                <input type="checkbox"
                                                id="checkAll{{$this->pageTitle}}"
                                                wire:model="select_page"
                                                wire:loading.attr="disabled">
                                                <label class="sr-only" for="checkAll{{$this->pageTitle}}">Click to check all items</label>
                                            </div>
                                        </th>
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
                                        </th>
                                        <th>
                                            Associated roles
                                        </th>
                                        <th>
                                            <span class="sr-only">Edit</span>
                                        </th>
                                        <th>
                                            <span class="sr-only">Delete</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $permission)
                                        <tr id="rowcheck{{$this->pageTitle}}{{ $permission->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                            <td width="10px">
                                                <div class="icheck-amethyst">
                                                    <input type="checkbox"
                                                    id="check{{$this->pageTitle}}{{$permission->id}}"
                                                    wire:model.defer="selected"
                                                    value="{{$permission->id}}"
                                                    onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                                    class="counter{{$this->pageTitle}}">
                                                    <label class="sr-only" for="check{{$this->pageTitle}}{{$permission->id}}">Click to check</label>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column mb-0">
                                                    {{ $permission->name }}
                                                </p>
                                            </td>
                                            <td>
                                                @foreach($permission->roles as $role)
                                                    <span class="text-uppercase badge bg-gradient-lime mx-2 text-xs">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td width="10px">
                                                @can('permissions_update')
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        wire:click.prevent="edit({{ $permission }})"
                                                        title="Edit"
                                                        class="btn btn-sm btn-link border border-0 icon">
                                                            <i class="fas fa-edit text-muted"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                            <td width="10px">
                                                @can('permissions_destroy')
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="destroy({{ $permission->id }})"
                                                        title="Delete"
                                                        class="btn btn-sm btn-link border border-0 icon">
                                                            <i class="fas fa-trash text-muted"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- COMMENT: Muestra cuando el componente esta readyToLoad -->
                                        @if($readyToLoad == true)
                                            <tr>
                                                <td colspan="5">
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
                        <!-- /.Datatable's when screen > md (card-body) -->

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
                        <div wire:loading.class="overlay dark" wire:target="store, update, destroy, destroyMultiple, undoMultiple">
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @include('livewire.permission.form')
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script type="text/javascript">
    window.addEventListener('stored', event => {
        notify(event)
    });

    window.addEventListener('updated', event => {
        notify(event)
    });

    window.addEventListener('deleted', event => {
        notify(event)
    });

    window.addEventListener('destroy-error', event => {
        notify(event)
    });

    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msg =>  {
            $('#modalForm{{$this->pageTitle}}').modal('show')
        });
        window.livewire.on('hide-modal', msg =>  {
            $('#modalForm{{$this->pageTitle}}').modal('hide')
        });
    });
</script>
