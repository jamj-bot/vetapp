<div wire:init="loadItems">
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
{{--                         <button id="destroyMultiple{{$this->pageTitle}}" type="button" wire:click="destroyMultiple"
                            class="btn bg-gradient-danger btn-block btn-sm shadow-sm border-0 {{ $this->select_page ? '' : 'd-none' }}"
                            wire:loading.attr="disabled"  wire:target="destroyMultiple">
                                <span wire:loading.remove wire:target="destroyMultiple">
                                    <i class="fas fa-fw fa-trash"></i>Delete {{ Str::of($this->pageTitle)->plural() }}
                                </span>
                                <span wire:loading wire:target="destroyMultiple">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i> Deleting {{ Str::of($this->pageTitle)->plural() }}
                                </span>
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-auto">
            <!-- Filter Button -->
            <div x-data="{
                    direction_dumpster: $persist(@entangle('direction')),
                    paginate_dumpster:  $persist(@entangle('paginate')),
                    {{-- filter_dumpster:    $persist(@entangle('filter')),  --}}
                    model_dumpster:     $persist(@entangle('model')),
                    sort_dumpster:      $persist(@entangle('sort')),
                }">
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-default dropdown-toggle shadow-sm border-0" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-fw fa-filter"></i> {{ ucfirst($this->model)}}
                </button>
                <div class="dropdown-menu">
                    <button class="dropdown-item {{ $this->model == 'pets' ? 'active':''}}" type="button" wire:click="$set('model', 'pets')">
                        Pets
                    </button>
                    <button class="dropdown-item {{ $this->model == 'appointments' ? 'active':''}}" type="button" wire:click="$set('model', 'appointments')">
                        Appointments
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
                            <i class="fas fa-fw fa-history"></i></i>Restore {{ ucfirst($this->model) }}
                        </span>
                        <span wire:loading wire:target="restoreMultiple">
                            <i class="fas fa-fw fa-spinner fa-spin"></i> Restoring {{ ucfirst($this->model) }}
                        </span>
                </button>
            @endcan
        </div>
    </div>

    <div class="card card-outline card-danger">
        <div class="card-header border-transparent">
            <h3 class="card-title">
                @if($this->select_page)
                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                @else
                    <span id="dynamicText{{$this->pageTitle}}">Dumpster</span>
                @endif
            </h3>
        </div>
        <!-- /.card-header -->

        <!-- Datatable's when screen < md-->
        <div class="card-body p-0 d-md-none pt-5">
            <div class="table-responsive">
                <table class="table m-0 table-hover text-sm">
                    <thead>
                        <tr class="text-uppercase">
                            <th>
                                Name
                            </th>
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
                                                        onclick="confirmDestroy('{{ $item->id }}', 'Are you sure you want delete this item?', 'You won\'t be able to revert this!', '{{ $item->model }}', 'destroy')"
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
        </div>

        <!-- Datatable's when screen > md-->
        @if($this->model == 'pets')
            <div class="card-body p-0 d-none d-md-block">
                <div class="table-responsive">
                    <table class="table m-0 table-hover text-sm datatable">
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
                                 <th {{--wire:click="order('name')"--}}>
                                    Name
                                    {{-- @if($sort == 'name')
                                        @if($direction == 'asc')
                                            <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                        @else
                                            <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                        @endif
                                    @else
                                        <i class="text-xs text-muted fas fa-sort"></i>
                                    @endif --}}
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
                                <tr id="rowcheck{{$this->pageTitle}}{{ $item->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}" wire:key="{{ $item->id }}">
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
                                                <i class="fas fa-fw fa-dog"></i>
                                                {{ $item->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $item->deleted_at->diffForHumans() }}</td>
                                    <td width="10px">
                                        @can('trash_restore')
                                            <a href="javascript:void(0)"
                                                wire:click.prevent="restore({{$item->id}})"
                                                title="Restore"
                                                class="btn btn-sm btn-link border border-0 icon">
                                                <i class="fas fa-history text-muted"></i>
                                            </a>
                                        @endcan
                                    </td>
                                    <td width="10px">
                                        @can('trash_destroy')
{{--                                             <a href="javascript:void(0)"
                                                wire:click.prevent="destroy({{$item->id}})"
                                                title="Destroy"
                                                class="btn btn-sm btn-link border border-0 icon">
                                                <i class="fas fa-trash text-muted"></i>
                                            </a> --}}
                                            <a href="javascript:void(0)"
                                                onclick="confirmDestroy('{{ $item->id }}', 'Are you sure you want delete this item?', 'You won\'t be able to revert this!', '{{ $item->model }}', 'destroy')"
                                                title="Delete definitively"
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
                            <span class="loader"></span>
                        </p>
                    </div>
                </div>
                <!-- /.table-responsive -->
            </div>
        @elseif($this->model == 'appointments')
            <div class="card-body p-0 d-none d-md-block">
                <div class="table-responsive">
                    <table class="table m-0 table-hover text-sm datatable">
                        <thead>
                            <tr class="text-uppercase">
                                <th>
                                    <div class="icheck-pomegranate">
                                        <input type="checkbox"
                                        id="checkAll{{$this->pageTitle}}"
                                        wire:model="select_page"
                                        wire:loading.attr="disabled">
                                        <label class="sr-only" for="checkAll{{$this->pageTitle}}">Click to check all items</label>
                                    </div>
                                </th>
                                <th>
                                    Veterinarian
                                </th>
                                <th>
                                    Booked Services
                                </th>
                                <th class="text-right">
                                    Date
                                </th>
                                <th>
                                    Time
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
                                <tr id="rowcheck{{$this->pageTitle}}{{ $item->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}" wire:key="{{ $item->id }}">
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
                                    <td class="{{ $item->pass ? 'text-muted' : '' }}">
                                        <span class="text-nowrap">
                                            <i class="fas fa-fw fa-calendar-check"></i>
                                            {{ $item->veterinarian->user->name }}
                                        </span>
                                    </td>

                                    <td class="{{ $item->pass ? 'text-muted' : '' }}">
                                        {{ $item->allServices }}
                                    </td>
                                    @if($item->pass)
                                        <td class="text-center text-muted" colspan="2">
                                            Your item has expired.
                                        </td>
                                    @else
                                        <td class="text-right">
                                            {{ $item->start_time->format('d-m-Y') }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $item->start_time->format('H:i') }} hrs
                                        </td>
                                    @endif
                                    <td>{{ $item->deleted_at->diffForHumans() }}</td>
                                    <td width="10px">
                                        @can('trash_restore')
                                            <a href="javascript:void(0)"
                                                wire:click.prevent="restore({{$item->id}})"
                                                title="Restore"
                                                class="btn btn-sm btn-link border border-0 icon">
                                                <i class="fas fa-history text-muted"></i>
                                            </a>
                                        @endcan
                                    </td>
                                    <td width="10px">
                                        @can('trash_destroy')
                                            <a href="javascript:void(0)"
                                                onclick="confirm('{{ $item->id }}', 'Are you sure you want delete this item?', 'You won\'t be able to revert this!', '{{ $item->model }}', 'destroy')"
                                                title="Delete definitively"
                                                class="btn btn-sm btn-link border border-0 icon">
                                                <i class="fas fa-trash text-muted"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                @if($readyToLoad == true)
                                    <tr>
                                        <td colspan="10">
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
                <!-- /.table-responsive -->
            </div>
        @endif
        <!-- /.card-body -->


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
        <div wire:loading.class="overlay dark" wire:target="undoMultiple, restore, restoreMultiple">
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    window.addEventListener('restored-dumpster', event => {
        notify(event)
    });

    window.addEventListener('restored-multiple-dumpster', event => {
        notify(event)
    });

    window.addEventListener('deleted-dumpster', event => {
        notify(event)
    });

    window.addEventListener('destroy-error-dumpster', event => {
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
