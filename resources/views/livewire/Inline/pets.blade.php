<div wire:init="loadItems">
    <!-- Datatable's filters when screen < md-->
    @include('common.datatable-filters-smaller-md')

    <!-- Datatable's filters when screen > md-->
    @include('common.datatable-filters-wider-md')

    <!-- Datatable's buttons -->
    <div class="d-flex justify-content-between mb-3">
        <div class="col-auto">
            <!-- Undo and destroy Buttons -->
            @can('species_destroy')
                @include('common.destroy-multiple-and-undo-buttons')
            @endcan
        </div>

        <div class="col-auto">
            <!-- Filter Button -->
            <div x-data="{
                    {{-- Enreda la propiedad 'model' y almacena su valor de manera persistente. --}}
                    direction_pets: $persist(@entangle('direction')),
                    paginate_pets:  $persist(@entangle('paginate')),
                    filter_pets:    $persist(@entangle('filter')),
                    sort_pets:      $persist(@entangle('sort')),
                }">
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-default dropdown-toggle shadow-sm border-0" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-fw fa-filter"></i> {{ $this->filter }} pets
                </button>
                <div class="dropdown-menu">
                    <button class="dropdown-item {{ $this->filter != 'Alive' && $this->filter != 'Dead' ? 'active':'' }}" type="button" wire:click="$set('filter', 'All')">
                        All
                    </button>
                    <button class="dropdown-item {{ $this->filter == 'Alive' ? 'active':'' }}" type="button" wire:click="$set('filter', 'Alive')">
                        Status: Alive
                    </button>
                    <button class="dropdown-item {{ $this->filter == 'Dead' ? 'active':'' }}" type="button" wire:click="$set('filter', 'Dead')">
                        Status: Dead
                    </button>
                </div>
            </div>
        </div>

        <div class="col-auto">
            <!-- Add Button -->
            @can('species_store')
                @include('common.add-button')
            @endcan
        </div>
    </div>

    <div class="card card-outline card-lightblue">
        <div class="card-header border-transparent">
            <h3 class="card-title">
                @if($this->select_page)
                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                @else
                    <span id="dynamicText{{$this->pageTitle}}">
                        {{ $filter == 'Alive' ? 'Active Pets' : '' }}
                        {{ $filter == 'Dead' ? 'Inactive Pets' : '' }}
                        {{ $filter == 'All' ? 'Pets' : '' }}
                    </span>
                @endif
            </h3>
        </div>
        <!-- /.card-header -->

        <!-- Datatable's when screen < md-->
        <div class="card-body p-0 d-md-none">
            <div class="table-responsive">
                <table class="table m-0 table-hover text-sm">
                    <thead>
                        <tr class="text-uppercase">
                            <th>
                                Name
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pets as $pet)
                            <tr data-widget="expandable-table" aria-expanded="false">
                                <td>
                                    <div class="d-flex justify-content-between align-items-center mx-1">
                                        <div>
                                            <a href="{{ route('admin.pets.show', $pet->id) }}">
                                                <img class="img-fluid rounded-circle elevation-2 shadow"
                                                loading="lazy"
                                                src="{{$pet->image ? asset('storage/pet-profile-photos/' . $pet->image) : 'https://ui-avatars.com/api/?name='.$pet->name.'&color=FFF&background=random&size=128'}}"
                                                style="width: 35px; height: 35px; object-fit: cover;"
                                                alt="{{ $pet->name }}">
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-uppercase">
                                                @can('pets_show')
                                                    <a href="{{ route('admin.pets.show', $pet) }}"
                                                        class="font-weight-bold" title="{{ $pet->name }}'s profile">
                                                        {{ $pet->name }}
                                                    </a>
                                                @else
                                                    {{ $pet->name }}
                                                @endcan
                                            </span>
                                            <span class="">
                                                @can('pets_show')
                                                    @if($pet->name == null)
                                                        <a href="{{ route('admin.pets.show', $pet) }}"
                                                            class="font-weight-bold" title="{{ $pet->code }}'s profile">
                                                            {{ $pet->code }}
                                                        </a>
                                                    @else
                                                     {{ $pet->code }}
                                                    @endif
                                                @else
                                                    {{ $pet->code }}
                                                @endcan
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="expandable-body d-none">
                                <td colspan="1">
                                    <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                        <div>
                                            <span class="text-uppercase font-weight-bold">Species</span>
                                        </div>
                                        <div class="d-flex flex-column text-right">
                                            <span class="">
                                                {{ $pet->common_name }}
                                            </span>
                                            <span class="font-italic text-muted">
                                                {{ $pet->scientific_name }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                        <div>
                                            <span class="text-uppercase font-weight-bold">Breed</span>
                                        </div>
                                        <div class="d-flex flex-column text-right">
                                            <span class="{{ !$pet->breed ? 'text-muted' : '' }}">
                                                {{ $pet->breed ? $pet->breed : 'Mixed / unknown breed' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                        <div>
                                            <span class="text-uppercase font-weight-bold sr-only">Options</span>
                                        </div>
                                        <div class="d-flex flex-column text-right">
                                            <span>
                                                @can('pets_update')
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        wire:click.prevent="edit({{ $pet }})"
                                                        title="Edit"
                                                        class="btn btn-sm btn-link border border-0">
                                                            <i class="fas fa-edit text-muted"></i>
                                                    </a>
                                                @endcan
                                                @can('pets_destroy')
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="destroy({{ $pet->id }})"
                                                        title="Delete"
                                                        class="btn btn-sm btn-link border border-0">
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
                        <span class="loader"></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Datatable's when screen > md-->
        <div class="card-body p-0 d-none d-md-block">
            <div class="table-responsive">
                <table class="table m-0 table-hover text-sm datatable">
                    <thead>
                        <tr class="text-uppercase">
                            <th>
                                <div class="icheck-info">
                                    <input type="checkbox"
                                    id="checkAll{{$this->pageTitle}}"
                                    wire:model="select_page"
                                    wire:loading.attr="disabled">
                                    <label class="sr-only" for="checkAll{{$this->pageTitle}}">Click to check all items</label>
                                </div>
                            </th>
                            <th colspan="2" wire:click="order('name')">
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
                            <tr id="rowcheck{{$this->pageTitle}}{{ $pet->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                <td width="10px">
                                    <div class="icheck-info">
                                        <input type="checkbox"
                                        id="check{{$this->pageTitle}}{{$pet->id}}"
                                        wire:model.defer="selected"
                                        value="{{$pet->id}}"
                                        onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                        class="counter{{$this->pageTitle}}">
                                        <label class="sr-only" for="check{{$this->pageTitle}}{{$pet->id}}">Click to check</label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pets.show', $pet->id) }}">
                                         <img class="{{--img-fluid--}} rounded-circle elevation-2 shadow"
                                            loading="lazy"
                                            src="{{$pet->image ? asset('storage/pet-profile-photos/' . $pet->image) : 'https://ui-avatars.com/api/?name='.$pet->name.'&color=FFF&background=random&size=128'}}"
                                            style="width: 35px; height: 35px; object-fit: cover;"
                                            alt="{{ $pet->name }}">
                                    </a>
                                </td>
                                <td class="text-nowrap">
                                    <a class="font-weight-bold btn-block text-uppercase {{ $pet->status == 'Alive' ? 'text-primary':'text-orange'}}"
                                        href="{{ route('admin.pets.show', $pet->id) }}">
                                        {{ $pet->name }}
                                        @if($pet->status == 'Dead')
                                            <sup class="font-weight-light">Inactive</sup>
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <p class="d-flex flex-column  mb-0">
                                        {{ $pet->code }}
                                    </p>
                                </td>
                                <td class="text-nowrap">
                                    <p class="d-flex flex-column mb-0">
                                        {{ $pet->breed ? $pet->breed : 'Mixed / unknown breed' }}
                                    </p>
                                </td>
                                <td class="text-nowrap">
                                    <span>{{ $pet->common_name}} /</span> <span class="font-italic text-muted">{{ $pet->scientific_name }}</span>
                                </td>
                                <td>
                                    @can('pets_update')
                                        <a href="javascript:void(0)"
                                            data-toggle="modal"
                                            wire:click.prevent="edit({{ $pet }})"
                                            title="Edit"
                                            class="btn btn-sm btn-link border border-0 icon">
                                                <i class="fas fa-edit text-muted"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td>
                                    @can('pets_destroy')
                                        <a href="javascript:void(0)"
                                            data-toggle="modal"
                                            wire:click.prevent="destroy({{ $pet->id }})"
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
                                    <td colspan="8">
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
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->


        <!-- card-footer -->
        @if(count($pets))
            @if($pets->hasPages())
                <div class="card-footer clearfix" style="display: block;">
                    <div class="mailbox-controls">
                        <div class="float-right pagination pagination-sm">
                            <div class="ml-4">
                                {{ $pets->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <!-- /.card-footer -->

        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
        <div wire:loading.class="overlay dark" wire:target="update, destroy">
        </div>
    </div>
    @include('livewire.forms.form-pets')
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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
    window.addEventListener('destroy-error', event => {
        notify(event)
    });

    window.addEventListener('restored', event => {
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