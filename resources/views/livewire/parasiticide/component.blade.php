<div wire:init="loadItems">
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
                                    <button id="btn-application" class="dropdown-item" type="button"
                                        onclick="changeColumnsVisibility(this.id)">
                                        Application
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <button id="btn-reapplication" class="dropdown-item" type="button"
                                        onclick="changeColumnsVisibility(this.id)">
                                        Reapplication
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
                        <div class="card-header bg-gradient-lime">
                            <h3 class="card-title">
                                @if($this->select_page)
                                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                                @else
                                    <span id="dynamicText{{$this->pageTitle}}">Parasiticides</span>
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
                                            Type
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($parasiticides as $parasiticide)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                <p class="d-flex flex-column mb-0">
                                                    {{ $parasiticide->name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column mb-0">
                                                    {{ $parasiticide->manufacturer }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column mb-0">
                                                    {{ $parasiticide->type }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body d-none">
                                            <td colspan="3">
                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Target Species</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ Str::ucfirst($parasiticide->species->implode('name', ', ')) }}.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Description</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="}">
                                                            {{ $parasiticide->description }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Dosage</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ $parasiticide->dose }}
                                                        </span>
                                                    </div>
                                                </div>

                                               <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Route of administration</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ $parasiticide->administration }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Primary application </span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                           {{ $parasiticide->primary_application }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Reaplication interval</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span class="">
                                                            {{ $parasiticide->reapplication_interval }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold sr-only">Options</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span>
                                                            @can('parasiticides_update')
                                                                <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    wire:click.prevent="edit({{ $parasiticide }})"
                                                                    title="Edit"
                                                                    class="btn btn-sm btn-link border border-0" style="width: 50px">
                                                                        <i class="fas fa-edit text-muted"></i>
                                                                </a>
                                                            @endcan
                                                            @can('parasiticides_destroy')
                                                                <a href="javascript:void(0)"
                                                                    wire:click.prevent="destroy({{ $parasiticide->id }})"
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
                                            <div class="icheck-emerland">
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
                                        <th wire:click="order('type')">
                                            Type
                                            @if($sort == 'type')
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
                                            Dosage
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
                                        <th wire:click="order('administration')" class="d-none" id="th-administration">
                                            Route of administration
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
                                        <th class="text-right d-none" id="th-application">
                                            Primary application
                                        </th>
                                        <th class="d-none" id="th-reapplication">
                                            Reapplication interval
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
                                    @forelse($parasiticides as $parasiticide)
                                        <tr id="rowcheck{{$this->pageTitle}}{{ $parasiticide->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                            <td width="10px">
                                                <div class="icheck-emerland">
                                                    <input type="checkbox"
                                                    id="check{{$this->pageTitle}}{{$parasiticide->id}}"
                                                    wire:model.defer="selected"
                                                    value="{{$parasiticide->id}}"
                                                    onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                                    class="counter{{$this->pageTitle}}">
                                                    <label class="sr-only" for="check{{$this->pageTitle}}{{$parasiticide->id}}">Click to check</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column text-left mb-0">
                                                    <span class="text-nowrap">
                                                        {{ $parasiticide->name }}
                                                    </span>
                                                    <span class="font-weight-bold text-uppercase">
                                                        {{ $parasiticide->manufacturer }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                {{ Str::ucfirst(optional($parasiticide->species)->implode('name', ', ')) }}.
                                            </td>
                                            <td>
                                                 {{ $parasiticide->type }} parasites
                                            </td>
                                            <td>
                                                 {{ $parasiticide->dose }}
                                            </td>
                                            <td>
                                                <div x-data="{ open: false }">
                                                    <span x-show="open">
                                                        {{ $parasiticide->description }}
                                                    </span>
                                                    <span x-show="! open">
                                                        {{ substr($parasiticide->description, 0, 75 ) }}
                                                    </span>
                                                    <button @click="open = ! open" type="text" class="btn btn-sm btn-link text-info p-0 {{ strlen($parasiticide->description) >= 75 ? '' : 'd-none' }}" :class="!open ? '' : 'text-orange'">
                                                        <span x-text="open ? '[Less]': '[More]'"></span>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="d-none td-administration">
                                                <span>
                                                    {{ $parasiticide->administration }}
                                                </span>
                                            </td>
                                            <td class="d-none td-application">
                                                <div class="d-flex flex-column text-right mb-0">
                                                    <span>
                                                        {{ $parasiticide->primary_application }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="d-none td-reapplication">
                                                <div class="d-flex flex-column text-left mb-0">
                                                    <span>
                                                        {{ $parasiticide->reapplication_interval }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @can('vaccines_update')
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        wire:click.prevent="edit({{ $parasiticide }})"
                                                        title="Edit"
                                                        class="btn btn-sm btn-link border border-0 icon" style="width: 20px">
                                                            <i class="fas fa-edit text-muted"></i>
                                                    </a>
                                                @endcan

                                            </td>
                                            <td>
                                                @can('vaccines_destroy')
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="destroy({{ $parasiticide->id }})"
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
                        @if(count($parasiticides))
                            @if($parasiticides->hasPages())
                                <div class="card-footer clearfix" style="display: block;">
                                    <div class="mailbox-controls">
                                        <div class="float-right pagination pagination-sm">
                                            <div class="ml-4">
                                                {{ $parasiticides->links() }}
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

    @include('livewire.parasiticide.form')

</div>

<!-- Css styles for checkboxes and radio buttons -->
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


    window.addEventListener('rendered', function() {

        if (localStorage.getItem('administration_toggled') === 'true') {
            document.getElementById("btn-administration").classList.add("active");
            document.getElementById("th-administration").classList.remove("d-none");
            document.querySelectorAll("td.td-administration").forEach((td) => {
                td.classList.remove("d-none")
            });
        }

        if (localStorage.getItem('application_toggled') === 'true') {
            document.getElementById("btn-application").classList.add("active");
            document.getElementById("th-application").classList.remove("d-none");
            document.querySelectorAll("td.td-application").forEach((td) => {
                td.classList.remove("d-none")
            });
        }

        if (localStorage.getItem('reapplication_toggled') === 'true') {
            document.getElementById("btn-reapplication").classList.add("active");
            document.getElementById("th-reapplication").classList.remove("d-none");
            document.querySelectorAll("td.td-reapplication").forEach((td) => {
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

        if (id == 'btn-application') {
            if (localStorage.getItem('application_toggled') === 'true'){
               localStorage.setItem('application_toggled','false');
            } else{
               localStorage.setItem('application_toggled','true');
            }

            // Cambia visibilidad del TH de la columna
            document.getElementById("btn-application").classList.toggle("active")

            // Cambia visibilidad del TH de la columna
            document.getElementById("th-application").classList.toggle("d-none")

            // Cambia visibilidad de los TDs de la columna
            document.querySelectorAll("td.td-application").forEach((td) => {
              td.classList.toggle("d-none")
            });
        }

        if (id == 'btn-reapplication') {
            if (localStorage.getItem('reapplication_toggled') === 'true'){
               localStorage.setItem('reapplication_toggled','false');
            } else{
               localStorage.setItem('reapplication_toggled','true');
            }

            // Cambia visibilidad del TH de la columna
            document.getElementById("btn-reapplication").classList.toggle("active")

            // Cambia visibilidad del TH de la columna
            document.getElementById("th-reapplication").classList.toggle("d-none")

            // Cambia visibilidad de los TDs de la columna
            document.querySelectorAll("td.td-reapplication").forEach((td) => {
              td.classList.toggle("d-none")
            });
        }
    }

</script>