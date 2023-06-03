<div wire:init="loadItems()" >
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
                            <div class="dropdown d-none d-md-block">
                                <button class="btn btn-sm btn-default dropdown-toggle shadow-sm border-0" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-fw fa-columns"></i> Columns
                                </button>
                                <div class="dropdown-menu">
                                    <button id="btn-administration" class="dropdown-item" type="button"
                                        onclick="changeColumnsVisibility(this.id)">
                                        Route of administration
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <button id="btn-vaccination" class="dropdown-item" type="button"
                                        onclick="changeColumnsVisibility(this.id)">
                                        Vaccination Schedule
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <button id="btn-revaccination" class="dropdown-item" type="button"
                                        onclick="changeColumnsVisibility(this.id)">
                                        Revaccination Schedule
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="col-auto">
                            <!-- Add Button -->
                            @can('vaccines_store')
                                @include('common.add-button')
                            @endcan
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-gradient-teal">
                            <h3 class="card-title">
                                @if($this->select_page)
                                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                                @else
                                    <span id="dynamicText{{$this->pageTitle}}">Vaccines</span>
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
                                        <th title="Manufacturer">
                                            Mfgr
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vaccines as $vaccine)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                <span class="text-uppercase font-weight-bold text-orange">
                                                    {{ $vaccine->name }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $vaccine->manufacturer }}
                                            </td>
                                            <td>
                                                {{ $vaccine->status }}
                                            </td>
                                        </tr>
                                        <tr class="expandable-body d-none">
                                            <td colspan="3">
                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Type</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ $vaccine->type }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Target Species</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ $vaccine->allSpecies }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Description</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="text-muted font-italic">
                                                            {{ $vaccine->allDiseases }}
                                                        </span>
                                                        <span>
                                                            {{ $vaccine->description }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Dosage</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ $vaccine->dosage }}
                                                        </span>
                                                    </div>
                                                </div>

                                               <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">RoA</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ $vaccine->administration }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Vaccination schedule </span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                           {{ $vaccine->vaccination_doses }} dosis
                                                        </span>
                                                        <span class="">
                                                            {{ $vaccine->vaccination_schedule }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Revaccination schedule</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ $vaccine->revaccination_doses }} dosis
                                                        </span>
                                                        <span class="">
                                                            {{ $vaccine->revaccination_schedule }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold sr-only">Options</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span>
                                                            @can('vaccines_update')
                                                                <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    wire:click.prevent="edit({{ $vaccine }})"
                                                                    title="Edit"
                                                                    class="btn btn-sm btn-link border border-0" style="width: 50px">
                                                                        <i class="fas fa-edit text-muted"></i>
                                                                </a>
                                                            @endcan
                                                            @can('vaccines_destroy')
                                                                <a href="javascript:void(0)"
                                                                    wire:click.prevent="destroy({{ $vaccine->id }})"
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
                                                <td colspan="3">
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

                            {{-- aquí va el paginador --}}
                        </div>
                        <!-- /. Datatable's when screen < md (card-body) -->

                        <!-- Datatable's when screen > md (card-body)-->
                        <div class="card-body table-responsive p-0 d-none d-md-block">
                            <table class="table table-head-fixed table-hover text-sm datatable">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>
                                            <div class="icheck-greensea">
                                                <input type="checkbox"
                                                id="checkAll{{$this->pageTitle}}"
                                                wire:model="select_page"
                                                wire:loading.attr="disabled">
                                                <label class="sr-only" for="checkAll{{$this->pageTitle}}">Click to check all items</label>
                                            </div>
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
                                        <th>
                                            Target Species
                                        </th>
                                        <th wire:click="order('status')" class="text-right">
                                            Status
                                            @if($sort == 'status')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th wire:click="order('administration')" class="d-none" id="th-administration">
                                            RoA
                                            @if($sort == 'administration')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th wire:click="order('description')">
                                            Description
                                            @if($sort == 'description')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th class="text-right d-none" id="th-vaccination">
                                            Vaccination schedule
                                        </th>
                                        <th class="d-none" id="th-revaccination">
                                            Revaccination schedule
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
                                    @forelse($vaccines as $vaccine)
                                        <tr id="rowcheck{{$this->pageTitle}}{{ $vaccine->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                            <td width="10px">
                                                <div class="icheck-greensea">
                                                    <input type="checkbox"
                                                    id="check{{$this->pageTitle}}{{$vaccine->id}}"
                                                    wire:model.defer="selected"
                                                    value="{{$vaccine->id}}"
                                                    onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                                    class="counter{{$this->pageTitle}}">
                                                    <label class="sr-only" for="check{{$this->pageTitle}}{{$vaccine->id}}">Click to check</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column text-left mb-0">
                                                    <span class="text-nowrap text-uppercase font-weight-bold text-orange">
                                                        {{ $vaccine->name }}
                                                    </span>
                                                    <span class="font-weight-bold text-uppercase">
                                                        {{ $vaccine->manufacturer }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $vaccine->allSpecies }}
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column text-right mb-0">
                                                    <span>
                                                        {{ $vaccine->status }}
                                                    </span>
                                                    <span class="text-muted">
                                                        {{ $vaccine->type }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="d-none td-administration">
                                                <div class="d-flex flex-column text-left mb-0">
                                                    <span>
                                                        {{ $vaccine->administration }}
                                                    </span>
                                                    <span class="text-muted">
                                                        {{ $vaccine->dosage }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div x-data="{ open: false }">
                                                    <span x-show="open">
                                                        {{ $vaccine->description }}
                                                        <span class="text-muted font-italic">
                                                            {{ $vaccine->allDiseases }}
                                                        </span>
                                                    </span>
                                                    <span x-show="! open">
                                                         {{ substr($vaccine->description, 0, 75 ) }}
                                                         <span class="text-muted font-italic">
                                                            {{ Str::words($vaccine->allDiseases, 2, ' >>>') }}
                                                        </span>
                                                    </span>
                                                    <button @click="open = ! open" type="text" class="btn btn-sm btn-link text-info p-0 {{ strlen($vaccine->description . $vaccine->allDiseases) >= 75 ? '' : 'd-none' }}" :class="!open ? '' : 'text-orange'">
                                                        <span x-text="open ? '[Less]': '[More]'"></span>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="d-none td-vaccination">
                                                <div class="d-flex flex-column text-right mb-0">
                                                    <span>
                                                        {{ $vaccine->vaccination_doses }} dosis
                                                    </span>
                                                    <span>
                                                        {{ $vaccine->vaccination_schedule }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="d-none td-revaccination">
                                                <div class="d-flex flex-column text-left mb-0">
                                                    <span>
                                                        {{ $vaccine->revaccination_doses }} dosis
                                                    </span>
                                                    <span>
                                                        {{ $vaccine->revaccination_schedule }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @can('vaccines_update')
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        wire:click.prevent="edit({{ $vaccine }})"
                                                        title="Edit"
                                                        class="btn btn-sm btn-link border border-0 icon" style="width: 20px">
                                                            <i class="fas fa-edit text-muted"></i>
                                                    </a>
                                                @endcan

                                            </td>
                                            <td>
                                                @can('vaccines_destroy')
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="destroy({{ $vaccine->id }})"
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
                        <!-- /. Datatable's when screen > md (card-body) -->

                        <!-- card-footer -->
                        @if(count($vaccines))
                            @if($vaccines->hasPages())
                                <div class="card-footer clearfix" style="display: block;">
                                    <div class="mailbox-controls">
                                        <div class="float-right pagination pagination-sm">
                                            <div class="ml-4">
                                                {{ $vaccines->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <!-- /.card-footer -->

                        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
                        <div wire:loading.class="overlay dark" wire:target="store, update, destroy, destroyMultiple, undoMultiple">
  {{--                           <div wire:loading wire:target="store, update, destroy, destroyMultiple, undoMultiple">
                                <span class="loader"></span>
                            </div> --}}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @include('livewire.vaccine.form')
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

<script type="text/javascript">

    window.addEventListener('rendered', function() {

        if (localStorage.getItem('administration_toggled') === 'true') {
            document.getElementById("btn-administration").classList.add("active");
            document.getElementById("th-administration").classList.remove("d-none");
            document.querySelectorAll("td.td-administration").forEach((td) => {
                td.classList.remove("d-none")
            });
        }

        if (localStorage.getItem('vaccination_toggled') === 'true') {
            document.getElementById("btn-vaccination").classList.add("active");
            document.getElementById("th-vaccination").classList.remove("d-none");
            document.querySelectorAll("td.td-vaccination").forEach((td) => {
                td.classList.remove("d-none")
            });
        }

        if (localStorage.getItem('revaccination_toggled') === 'true') {
            document.getElementById("btn-revaccination").classList.add("active");
            document.getElementById("th-revaccination").classList.remove("d-none");
            document.querySelectorAll("td.td-revaccination").forEach((td) => {
                td.classList.remove("d-none")
            });
        }
    });

    function changeColumnsVisibility(id) {

        if (id == 'btn-administration') {

            if (localStorage.getItem('administration_toggled') === 'true'){
               localStorage.setItem('administration_toggled','false');
            } else{
               localStorage.setItem('administration_toggled','true');
            }
            // Cambia visibilidad del TH de la columna
            document.getElementById("btn-administration").classList.toggle("active")

            // Cambia visibilidad del TH de la columna
            document.getElementById("th-administration").classList.toggle("d-none")

            // Cambia visibilidad de los TDs de la columna
            document.querySelectorAll("td.td-administration").forEach((td) => {
              td.classList.toggle("d-none")
            });
        }

        if (id == 'btn-vaccination') {
            if (localStorage.getItem('vaccination_toggled') === 'true'){
               localStorage.setItem('vaccination_toggled','false');
            } else{
               localStorage.setItem('vaccination_toggled','true');
            }

            // Cambia visibilidad del TH de la columna
            document.getElementById("btn-vaccination").classList.toggle("active")

            // Cambia visibilidad del TH de la columna
            document.getElementById("th-vaccination").classList.toggle("d-none")

            // Cambia visibilidad de los TDs de la columna
            document.querySelectorAll("td.td-vaccination").forEach((td) => {
              td.classList.toggle("d-none")
            });
        }

        if (id == 'btn-revaccination') {
            if (localStorage.getItem('revaccination_toggled') === 'true'){
               localStorage.setItem('revaccination_toggled','false');
            } else{
               localStorage.setItem('revaccination_toggled','true');
            }

            // Cambia visibilidad del TH de la columna
            document.getElementById("btn-revaccination").classList.toggle("active")

            // Cambia visibilidad del TH de la columna
            document.getElementById("th-revaccination").classList.toggle("d-none")

            // Cambia visibilidad de los TDs de la columna
            document.querySelectorAll("td.td-revaccination").forEach((td) => {
              td.classList.toggle("d-none")
            });
        }
    }

</script>
