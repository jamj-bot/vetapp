<div wire:init="loadItems">
    <!-- Datatable's filters -->
    <div class="row mb-2 mr-1">
        <div class="col-md-3">
            <div class="input-group input-group-sm m-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Show</label>
                </div>
                <select wire:model="paginate" wire:change="resetPagination" class="custom-select" id="inputGroupSelect01">
                    <option disabled>Choose...</option>
                    <option value="10">10 items</option>
                    <option selected value="50">50 items</option>
                    <option value="100">100 items</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm m-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect02">Only</label>
                </div>
                <select wire:model="filter" wire:change="resetPagination" class="custom-select" id="inputGroupSelect02">
                    <option disabled>Choose...</option>
                    <option selected value="Alive">Live pets</option>
                    <option value="Dead">Dead Pets</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            @include('common.search')
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm m-1">
                @can('vaccinations_store')
                    <!-- Button trigger modal -->
                    <button type="button" class="btn bg-gradient-primary btn-sm btn-block shadow" data-toggle="modal" data-target="#modalForm">
                       <i class="fas fa-fw fa-plus"></i> Add Pet
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- /.Datatable filters -->

    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">
                {{ $filter == 'Alive' ? 'Live Pets ':'Dead Pets' }}
            </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0 table-hover font-weight-light">
                    <thead>
                        <tr>
                            <th wire:click="order('code')">
                                Code
                                @if($sort == 'code')
                                    @if($direction == 'asc')
                                        <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="text-xs text-muted fas fa-sort"></i>
                                @endif
                            </th>
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
                            <th wire:click="order('breed')">
                                Breed
                                @if($sort == 'breed')
                                    @if($direction == 'asc')
                                        <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="text-xs text-muted fas fa-sort"></i>
                                @endif
                            </th>
                            <th wire:click="order('common_name')">
                                Species
                                @if($sort == 'common_name')
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
                        @forelse($pets as $pet)
                            <tr>
                                <td>
                                    {{ $pet->code }}
                                </td>
                                <td>
                                    <a class="font-weight-bold btn-block {{ $pet->status == 'Alive' ? 'text-warning':'text-muted'}}"
                                        href="{{ route('admin.pets.show', $pet->id) }}">
                                        {{ $pet->name}}
                                    </a>
                                </td>
                                <td>
                                    {{ $pet->breed != null ? $pet->breed :  'Unknown' }}
                                </td>
                                <td>
                                    {{ $pet->common_name}} / <span class="font-italic text-muted">{{ $pet->scientific_name }}</span>
                                </td>
                                <td>
                                    {{-- @can('vaccinations_update') --}}
                                        <a href="javascript:void(0)"
                                            data-toggle="modal"
                                            wire:click.prevent="edit({{ $pet }})"
                                            title="Edit"
                                            class="btn btn-sm btn-block btn-default shadow-sm">
                                                <i class="fas fa-edit"></i>
                                        </a>
                                   {{--  @endcan --}}
                                </td>
                                <td>
                                    {{-- @can('vaccinations_destroy') --}}
                                        <a href="javascript:void(0)"
                                            data-toggle="modal"
                                            wire:click.prevent="destroy({{ $pet }})"
                                            title="Delete"
                                            class="btn btn-sm btn-block btn-default shadow-sm">
                                                <i class="fas fa-trash"></i>
                                        </a>
                                   {{--  @endcan --}}
                                </td>
                            </tr>
                        @empty
                            <!-- COMMENT: Muestra cuando el componente esta readyToLoad -->
                            @if($readyToLoad == true)
                                <tr>
                                    <td colspan="4">
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
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->

        <div class="card-footer clearfix" style="display: block;">
            @if(count($pets))
                <div class="ml-2">
                    @if($pets->hasPages())
                        {{ $pets->links() }}
                    @endif
                </div>
            @endif
        </div>
        <!-- /.card-footer -->

        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
        <div wire:loading.class="overlay dark" wire:target="update, destroy">
        </div>
    </div>
    @include('livewire.forms.form-pets')
</div>

<script>


    window.addEventListener('updated', event => {
        notify(event)
    });
    window.addEventListener('stored', event => {
        notify(event)
    });
    window.addEventListener('deleted', event => {
        notify(event)
    });



    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msg =>  {
            $('#modalForm').modal('show')
        });
        window.livewire.on('hide-modal', msg =>  {
            $('#modalForm').modal('hide')
        });
    });
</script>