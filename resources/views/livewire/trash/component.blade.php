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
        <div class="container-fluid ">

            <!-- Datatable's filters when screen < md-->
            @include('common.datatable-filters-smaller-md')

            <!-- Datatable's filters when screen > md-->
            @include('common.datatable-filters-wider-md')

            <!-- Datatable's buttons -->
            <div class="d-flex justify-content-between mb-3">
                <div class="col-auto">
            <!-- Undo and destroy Buttons -->
            <div class="d-none d-md-block">
                <div class="d-flex justify-content-start">
                    <div class="mr-2">
                        <button type="button"
                            wire:click.prevent="undoMultiple"
                            title="Undo"
                            class="btn btn-default btn-block btn-sm shadow-sm border-0 {{ $this->deleted ? '' : 'd-none'}}"
                            wire:loading.attr="disabled" wire:target="undoMultiple">
                                <span wire:loading.remove wire:target="undoMultiple">
                                    <i class="fas fa-fw fa-undo"></i> Undo
                                </span>
                                <span wire:loading wire:target="undoMultiple">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i> Undoing
                                </span>
                        </button>
                    </div>
                    <div>
                        <a href="javascript:void(0)"
                            id="destroyMultiple{{$this->pageTitle}}"
                            onclick="confirmDestroyMultiple('Are you sure you want delete this items?', 'You won\'t be able to revert this!', '{{ $this->model }}', 'destroyMultiple')"
                            title="Delete definitively"
                            class="btn bg-gradient-danger btn-block btn-sm shadow-sm border-0 {{ $this->select_page ? '' : 'd-none' }}">
                                <span wire:loading.remove wire:target="destroyMultiple">
                                    <i class="fas fa-fw fa-trash"></i>Destroy {{ ucfirst($this->model) }}
                                </span>
                                <span wire:loading wire:target="destroyMultiple">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i> Destroying {{ ucfirst($this->model) }}
                                </span>
                        </a>
                    </div>
                </div>
            </div>
                    {{-- @include('common.destroy-multiple-and-undo-buttons') --}}
                </div>

                <div class="col-auto">
                    <!-- Filter Button -->
                    <div x-data="{
                            {{-- Enreda la propiedad 'model' y almacena su valor de manera persistente. --}}
                            model: $persist(@entangle('model')),
                        }">
                    </div>

                    <div class="dropdown">
                        <button class="tn btn-sm btn-default dropdown-toggle shadow-sm border-0" type="button" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-fw fa-filter"></i> {{ Str::of($this->model)->explode('\\')->slice(-1)->implode('\\') }}
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item {{ $this->model == 'App\Models\User' && $this->model != 'Dead' ? 'active':'' }}" type="button" wire:click="$set('model', 'App\\Models\\User')">
                                Users
                            </button>
                            <button class="dropdown-item {{ $this->model == 'App\Models\Species' ? 'active':'' }}" type="button" wire:click="$set('model', 'App\\Models\\Species')">
                                Species
                            </button>
                            <button class="dropdown-item {{ $this->model == 'App\Models\Vaccine' ? 'active':'' }}" type="button" wire:click="$set('model', 'App\\Models\\Vaccine')">
                                Vaccines
                            </button>
                            <button class="dropdown-item {{ $this->model == 'App\Models\Parasiticide' ? 'active':'' }}" type="button" wire:click="$set('model', 'App\\Models\\Parasiticide')">
                                Parasiticides
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    @can('trash_restore')
                        <button id="restoreMultiple{{$this->pageTitle}}" type="button" wire:click="restoreMultiple"
                            class="btn bg-gradient-success btn-block btn-sm shadow-sm border-0 {{ $this->select_page ? '' : 'd-none' }}"
                            wire:loading.attr="disabled"  wire:target="restoreMultiple">
                                <span wire:loading.remove wire:target="restoreMultiple">
                                    <i class="fas fa-fw fa-history"></i></i>Restore {{ Str::of($this->pageTitle)->plural() }}
                                </span>
                                <span wire:loading wire:target="restoreMultiple">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i> Restoring {{ Str::of($this->pageTitle)->plural() }}
                                </span>
                        </button>
                    @endcan
                </div>
            </div>

            <!--Datatable -->
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header bg-gradient-danger">
                            <h3 class="card-title">
                                @if($this->select_page)
                                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                                @else
                                    <span id="dynamicText{{$this->pageTitle}}">Dumpster</span>
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
{{--                                         <th>
                                            Model
                                        </th> --}}
                                        <th>
                                            Deleted at
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                <p class="d-flex flex-column mb-0">
                                                    {{ $item->name }}
                                                </p>
                                            </td>
                                            {{-- <td>
                                                <p class="d-flex flex-column mb-0 text-nowrap">
                                                    @if($this->model == 'App\Models\Species')
                                                        <i class="fas fa-fw fa-paw"></i>
                                                    @elseif($this->model == 'App\Models\User')
                                                        <i class="fas fa-fw fa-user"></i>
                                                   @elseif($this->model == 'App\Models\Vaccine')
                                                        <i class="fas fa-fw fa-syringe text-teal"></i>
                                                    @elseif($this->model == 'App\Models\Parasiticide')
                                                        <i class="fas fa-fw fa-bug text-lime"></i>
                                                    @endif
                                                    {{ Str::of($this->model)->explode('\\')->slice(-1)->implode('\\') }}
                                                </p>
                                            </td>--}}
                                            <td>
                                                <p class="d-flex flex-column mb-0">
                                                    {{ $item->deleted_at->diffForHumans() }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body d-none">
                                            <td colspan="3">
                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold sr-only">Options</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span>
                                                            @can('trash_restore')
                                                                <a href="javascript:void(0)"
                                                                    wire:click.prevent="restore({{$item->id}})"
                                                                    title="Restore"
                                                                    class="btn btn-sm btn-link border border-0">
                                                                    <i class="fas fa-history text-muted"></i>
                                                                </a>
                                                            @endcan
                                                            @can('trash_destroy')
                                                                <a href="javascript:void(0)"
                                                                    onclick="confirm('{{ $item->id }}', 'Are you sure you want delete this item?', 'You won\'t be able to revert this!', '{{ $item->model }}', 'destroy')"
                                                                    title="Delete definitively"
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

                        </div>
                        <!-- /. Datatable's when screen < md (card-body) -->

                        <!-- Datatable's when screen > md (card-body)-->
                        <div class="card-body table-responsive p-0 d-none d-md-block">
                            <table class="table table-head-fixed table-hover text-sm datatable">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>
                                            <div class="icheck-danger">
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
                                            Model
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
                                            <span class="sr-only">Restore</span>
                                        </th>
                                        <th>
                                            <span class="sr-only">Destroy</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr id="rowcheck{{$this->pageTitle}}{{ $item->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                            <td width="10px">
                                                <div class="icheck-danger">
                                                    <input type="checkbox"
                                                    id="check{{$this->pageTitle}}{{$item->id}}"
                                                    wire:model.defer="selected"
                                                    value="{{$item->id}}"
                                                    onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                                    class="counter{{$this->pageTitle}}">
                                                    <label class="sr-only" for="check{{$this->pageTitle}}{{$item->id}}">Click to check</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column text-left mb-0">
                                                    <span class="text-nowrap">
                                                        {{ $item->name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($this->model == 'App\Models\Species')
                                                    <i class="fas fa-fw fa-paw"></i>
                                                @elseif($this->model == 'App\Models\User')
                                                    <i class="fas fa-fw fa-user"></i>
                                               @elseif($this->model == 'App\Models\Vaccine')
                                                    <i class="fas fa-fw fa-syringe text-teal"></i>
                                                @elseif($this->model == 'App\Models\Parasiticide')
                                                    <i class="fas fa-fw fa-bug text-lime"></i>
                                                @endif
                                                {{ Str::of($this->model)->explode('\\')->slice(-1)->implode('\\') }}
                                            </td>
                                            <td>{{ $item->deleted_at->diffForHumans() }}</td>
                                            <td width="10px">
                                                @can('trash_restore')
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="restore({{$item->id}})"
                                                        title="Restore"
                                                        class="btn btn-sm btn-link border border-0">
                                                        <i class="fas fa-history text-muted"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                            <td width="10px">
                                                @can('trash_destroy')
                                                    <a href="javascript:void(0)"
                                                        onclick="confirmDestroy('{{ $item->id }}', 'Are you sure you want delete this item?', 'You won\'t be able to revert this!', '{{ $item->model }}', 'destroy')"
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
                        @if(count($items))
                            @if($items->hasPages())
                                <div class="card-footer clearfix" style="display: block;">
                                    <div class="mailbox-controls">
                                        <div class="float-right pagination pagination-sm">
                                            <div class="ml-4">
                                                {{ $items->links() }}
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
        </div>
    </section>
</div>

<!-- Alpine Plugins -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>

<!-- Alpine Core -->
{{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

<!-- Css styles for checkboxes and radio buttons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    window.addEventListener('restored', event => {
        notify(event)
    });

    window.addEventListener('restored-multiple', event => {
        notify(event)
    });

    window.addEventListener('deleted', event => {
        notify(event)
    });

    window.addEventListener('destroy-error', event => {
        notify(event)
    });


    function confirmDestroyMultiple(title, text, model, event) {
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
                window.livewire.emit(event),
                Swal.fire(
                    'Deleted!',
                     model + ' has been deleted.',
                    'success'
                )
            }
        })
    }

    function confirmDestroy(id, title, text, model, event) {
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
                window.livewire.emit(event, id),
                Swal.fire(
                    'Deleted!',
                     model + ' has been deleted.',
                    'success'
                )
            }
        })
    }
</script>