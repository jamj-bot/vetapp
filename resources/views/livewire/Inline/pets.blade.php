<div wire:init="loadItems">
{{--     <div class="row">
        <div class="col-12"> --}}
{{--             <div class="form-row d-flex justify-content-end">
                <div class="form-group col-12 col-sm-8 col-md-6">
                    <div class="btn-group btn-group-toggle btn-group-sm btn-block mb-2" data-toggle="buttons">
                        <label class="btn bg-gradient-gray {{ $this->filter == 'Alive' ? 'active' : '' }}">
                            <input type="radio" name="options" id="option_b1" autocomplete="off"  wire:click="$set('filter', 'Alive')">
                            <i class="fas fa-fw fa-dog"></i> <span class="font-weight-normal text-xs">Active</span>

                        </label>
                        <label class="btn bg-gradient-gray {{ $this->filter == 'Dead' ? 'active' : '' }}">
                            <input type="radio" name="options" id="option_b2" autocomplete="off"  wire:click="$set('filter', 'Dead')">
                            <i class="fas fa-fw fa-paw"></i> <span class="font-weight-normal text-xs">Inactive</span>
                        </label>
                    </div>
                </div>
            </div> --}}
{{--         </div>
    </div>
 --}}

    <!-- Datatable's filters when screen < md-->
    @include('common.datatable-filters-smaller-md')

    <!-- Datatable's filters when screen > md-->
    @include('common.datatable-filters-wider-md')

    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">
                {{ $filter == 'Alive' ? 'Active / alive Pets ':'Inactive / dead Pets ' }}
            </h3>

            <div class="card-tools">
                <!-- Add Button -->
                @can('pets_store')
                    @include('common.add-button')
                @endcan
            </div>
        </div>
        <!-- /.card-header -->

        <!-- Datatable's when screen < md-->
        <div class="card-body p-0 d-md-none">
            <div class="table-responsive">
                <table class="table m-0 table-hover text-sm">
                    <!-- Datatable's buttons -->
                    <div class="form-row d-flex justify-content-end m-2">
                        <div class="form-group col-12 col-sm-auto">
                            <div class="btn-group btn-group-toggle btn-group-sm btn-block" data-toggle="buttons">
                                <label class="btn {{ $this->filter == 'Alive' ? 'bg-gradient-primary active' : 'bg-gradient-gray' }}">
                                    <input type="radio" name="options" id="option_b1" autocomplete="off"  wire:click="$set('filter', 'Alive')">
                                    <i class="fas fa-fw fa-dog"></i> <span class="font-weight-normal text-xs">Active</span>

                                </label>
                                <label class="btn {{ $this->filter == 'Dead' ? 'bg-gradient-primary active' : 'bg-gradient-gray' }}">
                                    <input type="radio" name="options" id="option_b2" autocomplete="off"  wire:click="$set('filter', 'Dead')">
                                    <i class="fas fa-fw fa-paw"></i> <span class="font-weight-normal text-xs">Inactive</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <!-- Datatable's buttons -->

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
                                            <img class="img-circle elevation-2 shadow border border-2"
                                                loading="lazy"
                                                src="{{$pet->pet_profile_photo ? asset('storage/pet-profile-photos/' . $pet->pet_profile_photo) : 'https://ui-avatars.com/api/?name='.$pet->name.'&color=FFF&background=random&size=128'}}"
                                                style="width: 48px; height: 48px; object-fit: cover; background: antiquewhite;"
                                                alt="{{ $pet->name }}">
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
                                            <span class="text-uppercase font-weight-bold">Breed</span>
                                        </div>
                                        <div class="d-flex flex-column text-right">
                                            <span class="{{ !$pet->breed ? 'text-muted' : '' }}">
                                                {{ $pet->breed ? $pet->breed : 'Unspecified' }}
                                            </span>
                                            <span class="{{ !$pet->zootechnical_function ? 'text-muted' : '' }}">
                                                {{ $pet->zootechnical_function ? $pet->zootechnical_function : 'Undetermined' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mx-3">
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

                                    <div class="d-flex justify-content-between align-items-center mx-3">
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
                                                        wire:click.prevent="destroy({{ $pet }})"
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
                        {{-- <i class="fas fa-fw fa-spinner fa-spin"></i> --}}
                        <span class="loader"></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Datatable's when screen > md-->
        <div class="card-body p-0 d-none d-md-block" {{-- style="display: block;" --}}>
            <div class="table-responsive">
                <table class="table m-0 table-hover text-sm">

                    <!-- Datatable's buttons -->
                    <div class="form-row d-flex justify-content-between m-2">
                        <div class="col-md-auto">
                            <button id="destroyMultiple" wire:click="destroyMultiple" type="button" class="btn btn-default btn-sm btn-block {{ $this->select_page ? '' : 'd-none' }}">
                                <i class="fas fa-fw fa-trash"></i>
                                Delete <span id="counter" class="font-weight-bold">{{ count($this->selected) }}</span> items
                            </button>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="btn-group btn-group-toggle btn-group-sm btn-block" data-toggle="buttons">
                                <label class="btn {{ $this->filter == 'Alive' ? 'bg-gradient-primary active' : 'bg-gradient-gray' }}">
                                    <input type="radio" name="options" id="option_b1" autocomplete="off"  wire:click="$set('filter', 'Alive')">
                                    <i class="fas fa-fw fa-dog"></i> <span class="font-weight-normal text-xs">Active</span>

                                </label>
                                <label class="btn {{ $this->filter == 'Dead' ? 'bg-gradient-primary active' : 'bg-gradient-gray' }}">
                                    <input type="radio" name="options" id="option_b2" autocomplete="off"  wire:click="$set('filter', 'Dead')">
                                    <i class="fas fa-fw fa-paw"></i> <span class="font-weight-normal text-xs">Inactive</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Datatable's buttons -->

                    <thead>
                        <tr class="text-uppercase">
                            <th>
                                <div class="icheck-pomegranate">
                                    <input type="checkbox"
                                    id="checkAll"
                                    wire:model="select_page">
                                    <label class="sr-only" for="checkAll">Click to check all items</label>
                                </div>
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
                            <tr id="rowcheck{{ $pet->id }}" class="{{ $this->select_page ? 'table-active font-weight-bold' : ''}}">
                                <td width="10px">
                                    <div class="icheck-pomegranate">
                                        <input type="checkbox"
                                        id="check{{$pet->id}}"
                                        wire:model.defer="selected"
                                        value="{{$pet->id}}"
                                        onchange="updateInterface(this.id)"
                                        class="counter">
                                        <label class="sr-only" for="check{{$pet->id}}">Click to check</label>
                                    </div>
                                </td>
                                <td>
                                    <p class="d-flex flex-column  mb-0">
                                        {{ $pet->code }}
                                    </p>
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
                                <td class="text-nowrap">
                                    <p class="d-flex flex-column mb-0">
                                        {{ $pet->breed ? $pet->breed : 'Unspecified' }}
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
                                            class="btn btn-sm btn-link border border-0">
                                                <i class="fas fa-edit text-muted"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td>
                                    @can('pets_destroy')
                                        <a href="javascript:void(0)"
                                            data-toggle="modal"
                                            wire:click.prevent="destroy({{ $pet }})"
                                            title="Delete"
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
                                    <td colspan="7">
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


    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msg =>  {
            $('#modalForm').modal('show')
        });
        window.livewire.on('hide-modal', msg =>  {
            $('#modalForm').modal('hide')
        });
    });

    function updateInterface(id) {
        uncheckAll();
        trActive(id);
        count();
    }

    function uncheckAll() {
        // Desmarca checkAll si estaba seleccionado al hacer clic en una row
        if (document.getElementById('checkAll').checked) {
            document.getElementById('checkAll').checked = false
        }
    }

    function trActive(id) {
        // marca los TR como activados al hacer clic en una row
        var row = document.getElementById("rowcheck"+document.getElementById(id).value)
        row.classList.toggle("table-active")
        row.classList.toggle("font-weight-bold")
    }

    function count() {
        // Selecciona todos los input de tipo chechbox que tengan la clase counter y los cuenta

        document.getElementById("counter").innerHTML = document.querySelectorAll('input[type="checkbox"]:checked.counter').length

        if (document.querySelectorAll('input[type="checkbox"]:checked.counter').length < 1) {
            document.getElementById("destroyMultiple").classList.add("d-none");
        }
        if (document.querySelectorAll('input[type="checkbox"]:checked.counter').length > 0) {
            document.getElementById("destroyMultiple").classList.remove("d-none");
        }
    }

</script>