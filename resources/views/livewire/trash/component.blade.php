<div wire:init="loadItems()">
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">{{ $pageTitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                      <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid ">

            <!-- Buttons -->
            <div class="form-row d-flex justify-content-end">
                <div class="form-group col-md-3">
                    @can('trash_restore')
                        <button type="button" {{ count($items) < 1 ? 'disabled' : ''}}
                            class="btn bg-gradient-secondary btn-block shadow"
                            wire:click.prevent="restore"
                            title="Restore all users">
                            <i class="fas fa-fw fa-history"></i>
                                Restore all
                            <i wire:loading wire:target="restore" class="fas fa-spinner fa-spin"></i>
                        </button>
                    @endcan
                </div>
                <div class="form-group col-md-3">
                    @can('trash_destroy')
                        <button type="button" {{ count($items) < 1 ? 'disabled' : ''}}
                            class="btn bg-gradient-danger btn-block shadow"
                            onclick="confirm(null, 'Are you sure you want permanently delete all users?', 'You won\'t be able to revert this!', 'Users', 'destroy')"
                                title="Empty Recycle Bin">
                           <i class="fas fa-fw fa-trash"></i>
                                Empty Recycle Bin
                        </button>
                    @endcan
                </div>
            </div>

            <!--Datatable -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gradient-primary">
                            <h3 class="card-title">Deleted items</h3>
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
                                                <option value="50">50 items</option>
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
                            <table class="table table-head-fixed table-hover text-sm">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th wire:click="order('name')">
                                            Name

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
                                        <th wire:click="order('model')">
                                            Type

                                            @if($sort == 'model')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th wire:click="order('deleted_at')">
                                            Deleted at

                                            @if($sort == 'deleted_at')
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
                                            <span class="sr-only">Edit</span>
                                        </th>
                                        <th>
                                            <span class="sr-only">Delete</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>
                                                <p class="d-flex flex-column font-weight-light mb-0">
                                                    <span>
                                                        @if($item->model == 1)
                                                            <i class="fas fa-square text-lime"></i>
                                                        @elseif($item->model == 2)
                                                            <i class="fas fa-square text-maroon"></i>
                                                        @elseif($item->model == 3)
                                                            <i class="fas fa-square text-purple"></i>
                                                        @elseif($item->model == 4)
                                                            <i class="fas fa-square text-orange"></i>
                                                        @elseif($item->model == 5)
                                                            <i class="fas fa-square text-lightblue"></i>
                                                        @endif
                                                        {{ $item->name }}
                                                    </span>
                                                </p>
                                            </td>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column font-weight-light mb-0">
                                                    <span>
                                                        @if($item->model == 1)
                                                            <i class="text-muted fas fa-fw fa-user"></i>
                                                            User
                                                        @elseif($item->model == 2)
                                                            <i class="text-muted fas fa-fw fa-paw"></i>
                                                            Species
                                                        @elseif($item->model == 3)
                                                            <i class="text-muted fas fa-fw fa-dog"></i>
                                                            Pet
                                                        @elseif($item->model == 4)
                                                            <i class="text-muted fas fa-fw fa-syringe"></i>
                                                            Vaccine
                                                        @elseif($item->model == 5)
                                                            <i class="text-muted fas fa-fw fa-bug"></i>
                                                            Parasiticide
                                                        @endif
                                                    </span>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column font-weight-light mb-0">
                                                    {{ $item->deleted_at->diffForHumans() }}
                                                </p>
                                            </td>
                                            <td width="10px">
                                                @can('trash_restore')
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="restore({{$item->id}}, {{$item->model}})"
                                                        title="Restore"
                                                        class="btn btn-sm btn-link border border-0">
                                                        <i class="fas fa-history text-muted"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                            <td width="10px">
                                                @can('trash_destroy')
                                                    <a href="javascript:void(0)"
                                                        onclick="confirmDelete('{{ $item->id }}', 'Are you sure you want delete this item?', 'You won\'t be able to revert this!', '{{ $item->model }}', 'destroy')"
                                                        title="Delete definitively"
                                                        class="btn btn-sm btn-link border border-0">
                                                        <i class="fas fa-trash text-muted"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- COMMENT: Muestra cuando el componente esta readyToLoad -->
                                        @if($readyToLoad == true)
                                            <tr>
                                                <td colspan="6">
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
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix" style="display: block;">
                            @if(count($items))
                                <div class="ml-4">
                                    @if($items->hasPages())
                                        {{ $items->links() }}
                                    @endif
                                </div>
                            @endif
                        </div>
                        <!-- /.card-footer -->

                        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
                        <div wire:loading.class="overlay dark" wire:target="restore">
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    window.addEventListener('restored', event => {
        notify(event)
    });

    {{-- Funtion to confirm the deletion of items --}}
    function confirmDelete(id, title, text, model, event) {
        Swal.fire({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.livewire.emit(event, id, model),
                Swal.fire(
                    'Deleted!',
                     model + ' has been deleted.',
                    'success'
                )
            }
        })
    }
</script>