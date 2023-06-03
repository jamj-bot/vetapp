<div wire:init="loadItems">
    <!-- Datatable's filters when screen < md-->
    @include('common.datatable-filters-smaller-md')

    <!-- Datatable's filters when screen > md-->
    @include('common.datatable-filters-wider-md')

    <!-- Datatable's buttons -->
    <div class="d-flex justify-content-between mb-3">
        <div class="col-auto">
            <!-- Undo and destroy Buttons -->
            @can('vaccinations_destroy')
                @include('common.destroy-multiple-and-undo-buttons')
            @endcan
        </div>

        <div class="col-auto">
            <!-- Add Button -->
            @can('vaccinations_store')
                @include('common.add-button')
            @endcan
        </div>
    </div>

    {{--<div class="d-none" x-data="{
             Enreda la propiedad 'model' y almacena su valor de manera persistente.
            direction: $persist(@entangle('direction')),
            paginate:  $persist(@entangle('paginate')),
            sort:      $persist(@entangle('sort')),
        }">
    </div>--}}

    <div class="card card-outline card-teal">
        <div class="card-header border-transparent">
            <h3 class="card-title">
                @if($this->select_page)
                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                @else
                    <span id="dynamicText{{$this->pageTitle}}">Vaccination Schedule</span>
                @endif
            </h3>

            <div class="card-tools">
                <!-- Maximize Button -->
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->

{{--         <div class="card-body table-responsive p-0 d-md-none">
            <table class="table table-head-fixed table-hover text-sm">
                <thead>
                    <tr class="text-uppercase">
                        <th>
                            <div class="icheck-turquoise">
                                <input type="checkbox"
                                id="checkAll"
                                wire:model="select_page"
                                wire:loading.attr="disabled">
                                <label class="sr-only" for="checkAll">Click to check all items</label>
                            </div>
                        </th>
                        <th>
                            Name
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vaccinations as $vaccination)
                        <tr id="rowcheck{{ $vaccination->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                            <td width="5px">
                                <div class="icheck-turquoise">
                                    <input type="checkbox"
                                    id="check{{$vaccination->id}}"
                                    wire:model.defer="selected"
                                    value="{{$vaccination->id}}"
                                    onchange="updateInterface(this.id)"
                                    class="counter">
                                    <label class="sr-only" for="check{{$vaccination->id}}">Click to check</label>
                                </div>
                            </td>
                            <td>
                                 <span x-data="{ open: false }">
                                    <div  class="d-flex justify-content-between align-items-center mx-1"  @click="open = ! open" title="More" style="cursor: pointer">
                                        <span class="text-uppercase font-weight-bold text-orange">
                                            @if($vaccination->applied)
                                                <img src="{{asset('storage/icons/vaccine-success.svg')}}" height="18" class="pr-2" />
                                            @endif
                                            @if(!$vaccination->applied && $vaccination->done->isFuture())
                                                <img src="{{asset('storage/icons/vaccine-warning.svg')}}" height="18" class="pr-2" />
                                            @endif

                                            @if(!$vaccination->applied && $vaccination->done->isPast())
                                                <img src="{{asset('storage/icons/vaccine-danger.svg')}}" height="18" class="pr-2" />
                                            @endif
                                            {{ $vaccination->name}}
                                        </span>
                                    </div>

                                    <div x-show="open" class="mb-0" x-collapse.duration.750ms @click.outside="open = false">
                                        <div class="d-flex justify-content-between align-items-center mx-1 my-2">
                                            <div>
                                                <span class="text-uppercase font-weight-bold">Type</span>
                                            </div>
                                            <div class="d-flex flex-column text-right">
                                                {{ $vaccination->type }}
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mx-1 my-2">
                                            <div>
                                                <span class="text-uppercase font-weight-bold">Progress</span>
                                            </div>
                                            <div class="d-flex flex-column text-right">
                                                <div class="progress-group">
                                                    {{ $vaccination->dose_number }}{{ $vaccination->dose_number == 1 ? 'st' : '' }}{{ $vaccination->dose_number == 2 ? 'nd' : '' }}{{ $vaccination->dose_number == 3 ? 'rd' : '' }}{{ $vaccination->dose_number > 3 ? 'th' : '' }} dose of {{ $vaccination->doses_required }}
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar {{ $vaccination->applied ? 'bg-success':'' }}
                                                                {{ !$vaccination->applied && $vaccination->done->isPast() ? 'bg-danger':'' }}
                                                                {{ !$vaccination->applied && $vaccination->done->isFuture() ? 'bg-warning':'' }}"
                                                            style="width: {{ ($vaccination->dose_number/$vaccination->doses_required)*100 }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mx-1 my-2">
                                            <div>
                                                <span class="text-uppercase font-weight-bold">Batch number</span>
                                            </div>
                                            <div class="d-flex flex-column text-right">
                                                {{ $vaccination->batch_number ? $vaccination->batch_number : 'null' }}
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mx-1 my-2">
                                            <div>
                                                <span class="text-uppercase font-weight-bold">Applied</span>
                                            </div>
                                            <div class="d-flex flex-column text-right">
                                                @can('vaccinations_apply')
                                                    <!-- Button trigger modal -->
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modalApply"
                                                        wire:click.prevent="editApply({{ $vaccination }})"
                                                        onclick="setValuesModalApply('{{$vaccination->name}}')"
                                                        title="Apply / Undo apply"
                                                        class="btn btn-link btn-block text-black">
                                                            {{ $vaccination->done->format('d-M-Y') }}
                                                            @if($vaccination->applied)
                                                                <img src="{{asset('storage/icons/vaccine-success.svg')}}" height="18" class="pr-2" />
                                                            @endif
                                                            @if(!$vaccination->applied && $vaccination->done->isFuture())
                                                                <img src="{{asset('storage/icons/vaccine-warning.svg')}}" height="18" class="pr-2" />
                                                            @endif

                                                            @if(!$vaccination->applied && $vaccination->done->isPast())
                                                                <img src="{{asset('storage/icons/vaccine-danger.svg')}}" height="18" class="pr-2" />
                                                            @endif
                                                    </a>
                                                @endcan
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mx-1 my-2">
                                            <div>
                                                <span class="text-uppercase font-weight-bold sr-only">Options</span>
                                            </div>
                                            <div class="d-flex flex-column text-right">
                                                <span>
                                                    @can('vaccinations_update')
                                                        <a href="javascript:void(0)"
                                                            data-toggle="modal"
                                                            wire:click.prevent="edit({{ $vaccination }})"
                                                            title="Edit"
                                                            class="btn btn-sm btn-link border border-0">
                                                                <i class="fas fa-edit text-muted"></i>
                                                        </a>
                                                    @endcan
                                                   @can('vaccinations_destroy')
                                                        <a href="javascript:void(0)"
                                                            onclick="confirm('{{$vaccination->id}}', 'Are you sure you want delete this vaccination?', 'You won\'t be able to revert this!', 'Vaccination', 'destroy')"
                                                            title="Delete"
                                                            class="btn btn-sm btn-link border border-0">
                                                                <i class="fas fa-trash text-muted"></i>
                                                        </a>
                                                    @endcan
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </span>
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
        </div> --}}

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
                    @forelse($vaccinations as $vaccination)
                        <tr data-widget="expandable-table" aria-expanded="false">
                            <td>
                                <div class="d-flex justify-content-between align-items-center mx-1">
                                    <div>
                                        @if($vaccination->applied)
                                            <img src="{{asset('storage/icons/vaccine-success.svg')}}" height="26" class="pr-2" />
                                        @endif
                                        @if(!$vaccination->applied && $vaccination->done->isFuture())
                                            <img src="{{asset('storage/icons/vaccine-warning.svg')}}" height="26" class="pr-2" />
                                        @endif

                                        @if(!$vaccination->applied && $vaccination->done->isPast())
                                            <img src="{{asset('storage/icons/vaccine-danger.svg')}}" height="26" class="pr-2" />
                                        @endif
                                        <span class="text-uppercase font-weight-bold text-orange">
                                            {{ $vaccination->name}}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column text-right">
                                        <span>
                                            {{ $vaccination->type }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="expandable-body d-none">
                            <td colspan="1">
                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                    <div>
                                        <span class="text-uppercase font-weight-bold">Progress</span>
                                    </div>
                                    <div class="d-flex flex-column text-right">
                                        <div class="progress-group">
                                            {{ $vaccination->dose_number }}{{ $vaccination->dose_number == 1 ? 'st' : '' }}{{ $vaccination->dose_number == 2 ? 'nd' : '' }}{{ $vaccination->dose_number == 3 ? 'rd' : '' }}{{ $vaccination->dose_number > 3 ? 'th' : '' }} dose of {{ $vaccination->doses_required }}
                                            <div class="progress progress-sm">
                                                <div class="progress-bar {{ $vaccination->applied ? 'bg-success':'' }}
                                                        {{ !$vaccination->applied && $vaccination->done->isPast() ? 'bg-danger':'' }}
                                                        {{ !$vaccination->applied && $vaccination->done->isFuture() ? 'bg-warning':'' }}"
                                                    style="width: {{ ($vaccination->dose_number/$vaccination->doses_required)*100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                    <div>
                                        <span class="text-uppercase font-weight-bold">Batch number</span>
                                    </div>
                                    <div class="d-flex flex-column text-right">
                                        <span class="">
                                            {{ $vaccination->batch_number }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                    <div>
                                        <span class="text-uppercase font-weight-bold">Applied</span>
                                    </div>
                                    <div class="d-flex flex-column text-right">
                                        @can('vaccinations_apply')
                                            <!-- Button trigger modal -->
                                            <a href="javascript:void(0)"
                                                data-toggle="modalApply"
                                                wire:click.prevent="editApply({{ $vaccination }})"
                                                onclick="setValuesModalApply('{{$vaccination->name}}')"
                                                title="Apply / Undo apply"
                                                class="btn btn-sm btn-default shadow-sm">
                                                    <i class="fas fa-fw fa-flag
                                                        {{ $vaccination->applied ? 'text-success':'' }}
                                                        {{ !$vaccination->applied && $vaccination->done->isPast() ? 'text-danger':'' }}
                                                        {{ !$vaccination->applied && $vaccination->done->isFuture() ? 'text-warning':'' }} ">
                                                    </i>
                                                    {{ $vaccination->done->format('d-M-Y') }}
                                            </a>
                                        @endcan
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
        <!-- /. Datatable's when screen < md (card-body) -->

        <!-- Datatable's when screen > md (card-body)-->
        <div class="card-body table-responsive p-0 d-none d-md-block">
            <div class="table-responsive">
                <table class="table m-0 table-hover text-sm datatable">
                    <thead>
                        <tr class="text-uppercase">
                            <th>
                                <div class="icheck-turquoise">
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
                            <th width="170px">
                                Progress
                            </th>
                            <th>
                                Batch number
                            </th>
                            <th wire:click="order('done')">
                                Applied
                                @if($sort == 'done')
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
                        @forelse($vaccinations as $vaccination)
                            <tr id="rowcheck{{$this->pageTitle}}{{ $vaccination->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                <td width="10px">
                                    <div class="icheck-turquoise">
                                        <input type="checkbox"
                                        id="check{{$this->pageTitle}}{{$vaccination->id}}"
                                        wire:model.defer="selected"
                                        value="{{$vaccination->id}}"
                                        onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                        class="counter{{$this->pageTitle}}">
                                        <label class="sr-only" for="check{{$this->pageTitle}}{{$vaccination->id}}">Click to check</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        @if($vaccination->applied)
                                            <img src="{{asset('storage/icons/vaccine-success.svg')}}" height="26" class="pr-2" />
                                        @endif
                                        @if(!$vaccination->applied && $vaccination->done->isFuture())
                                            <img src="{{asset('storage/icons/vaccine-warning.svg')}}" height="26" class="pr-2" />
                                        @endif

                                        @if(!$vaccination->applied && $vaccination->done->isPast())
                                            <img src="{{asset('storage/icons/vaccine-danger.svg')}}" height="26" class="pr-2" />
                                        @endif

                                        <p class="d-flex flex-column text-left text-sm text-nowrap mb-0">
                                            <span class="text-uppercase font-weight-bold text-orange">
                                                {{ $vaccination->name}}
                                            </span>
                                            <span>
                                                {{ $vaccination->type }}
                                            </span>
                                        </p>
                                    </div>
                                </td>
                                <td class="text-sm">
                                    <div class="progress-group">
                                        {{ $vaccination->dose_number }}{{ $vaccination->dose_number == 1 ? 'st' : '' }}{{ $vaccination->dose_number == 2 ? 'nd' : '' }}{{ $vaccination->dose_number == 3 ? 'rd' : '' }}{{ $vaccination->dose_number > 3 ? 'th' : '' }} dose of {{ $vaccination->doses_required }}
                                        <div class="progress progress-sm">
                                            <div class="progress-bar {{ $vaccination->applied ? 'bg-success':'' }}
                                                    {{ !$vaccination->applied && $vaccination->done->isPast() ? 'bg-danger':'' }}
                                                    {{ !$vaccination->applied && $vaccination->done->isFuture() ? 'bg-warning':'' }}"
                                                style="width: {{ ($vaccination->dose_number/$vaccination->doses_required)*100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <p class="d-flex flex-column text-sm mb-0">
                                            <span class="text-sm">{{ $vaccination->batch_number }}</span>
                                        </p>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    @can('vaccinations_apply')
                                        <!-- Button trigger modal -->
                                        <a href="javascript:void(0)"
                                            data-toggle="modalApply"
                                            wire:click.prevent="editApply({{ $vaccination }})"
                                            onclick="setValuesModalApply('{{$vaccination->name}}')"
                                            title="Apply / Undo apply"
                                            class="btn btn-sm btn-default shadow-sm">
                                                <i class="fas fa-fw fa-flag
                                                    {{ $vaccination->applied ? 'text-success':'' }}
                                                    {{ !$vaccination->applied && $vaccination->done->isPast() ? 'text-danger':'' }}
                                                    {{ !$vaccination->applied && $vaccination->done->isFuture() ? 'text-warning':'' }} ">
                                                </i>
                                                {{ $vaccination->done->format('d-M-Y') }}
                                        </a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('vaccinations_update')
                                        <a href="javascript:void(0)"
                                            data-toggle="modal"
                                            wire:click.prevent="edit({{ $vaccination }})"
                                            title="Edit"
                                            class="btn btn-sm btn-link border border-0 icon">
                                                <i class="fas fa-edit text-muted"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('vaccinations_destroy')
                                        <a href="javascript:void(0)"
                                            wire:click.prevent="destroy({{ $vaccination->id }})"
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
                        <span class="loader"></span>
                    </p>
                </div>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /. Datatable's when screen > md (card-body) -->

        <div class="card-footer clearfix" style="display: block;">

            <div class="d-flex flex-row justify-content-end text-xs">
                <span class="mr-2">
                    <i class="fas fa-square text-success"></i> Applied
                </span>

                <span class="mr-2">
                    <i class="fas fa-square text-warning"></i> Schenduled
                </span>

                <span>
                    <i class="fas fa-square text-danger"></i> Delayed
                </span>
            </div>

            @if(count($vaccinations))
                <div class="ml-2">
                    @if($vaccinations->hasPages())
                        {{ $vaccinations->links() }}
                    @endif
                </div>
            @endif

            <div class="mailbox-controls with-border text-center">
                <a href="{{ route('admin.pets.vaccinations.export', ['pet' => $pet]) }}"
                    class="btn btn-default btn-sm"
                    target="_blank"
                    rel="noopener"
                    title="Print">
                    <i class="far fa-fw fa-file-pdf"></i> Export
                </a>
            </div>
            <!-- /.mailbox-controls -->
        </div>
        <!-- /.card-footer -->

        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
        <div wire:loading.class="overlay dark" wire:target="apply, update, destroy, destroyMultiple, undoMultiple">
        </div>

    </div>

    <!-- Add and edit vaccinations -->
    @include('livewire.forms.form-vaccinations')

    <!-- Apply vaccinations -->
    @include('livewire.forms.form-apply-vaccinations')
</div>

{{-- Icheckbootstrap --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Flatpickr --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

<script>
    window.addEventListener('applied', event => {
        notify(event)
    });
    window.addEventListener('undo-applied', event => {
        notify(event)
    });
    window.addEventListener('updated', event => {
        notify(event)
    });
    window.addEventListener('stored', event => {
        notify(event)
    });
    window.addEventListener('deleted', event => {
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
        window.livewire.on('show-modal-apply', msg =>  {
            $('#modalFormApply').modal('show')
        });
        window.livewire.on('hide-modal-apply', msg =>  {
            $('#modalFormApply').modal('hide')
        });

        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            // minDate: 'today',
            //maxDate: new Date().fp_incr(14), // 14 days from now
            defaultDate: ["today"],
            dateFormat: 'Y-m-d',
            weekNumbers: true,
            "disable": [
                function(date) {
                    // return true to disable
                    return (date.getDay() === 0); // Disable sunday

                }
            ],
            "locale": {
                firstDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            },
        })
    });
</script>

