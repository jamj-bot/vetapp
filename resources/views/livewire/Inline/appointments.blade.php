<div wire:init="loadItems">

        <!-- Datatable's filters when screen < md-->
    @include('common.datatable-filters-smaller-md')

    <!-- Datatable's filters when screen > md-->
    @include('common.datatable-filters-wider-md')

    <!-- Datatable's buttons -->
    <div class="d-flex justify-content-between mb-3">
        <div class="col-auto">
            <!-- Undo and destroy Buttons -->
            @can('appointments_destroy')
                @include('common.destroy-multiple-and-undo-buttons')
            @endcan
        </div>
        <div class="col-auto">
            <!-- Add Button -->
            @can('appointments_store')
                @include('common.add-button')
            @endcan
        </div>
    </div>


    <div class="card card-outline card-maroon">
        <div class="card-header border-transparent">
            <h3 class="card-title">
               @if($this->select_page)
                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                @else
                    <span id="dynamicText{{$this->pageTitle}}">Appointments</span>
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
                                Vetererinarian
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr data-widget="expandable-table" aria-expanded="false">
                                <td>
                                    <div class="d-flex justify-content-between align-items-center mx-1">
                                        <div>
                                            {{ $appointment->veterinarian->user->name }}
                                        </div>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-uppercase">
                                            {{ $appointment->start_time->format('d-m-Y') }}
                                            </span>
                                            <span class="">
                                            {{ $appointment->start_time->format('H:i') }} hrs
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="expandable-body d-none">
                                <td colspan="1">
                                    <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                        <div>
                                            <span class="text-uppercase font-weight-bold">Booked services</span>
                                        </div>
                                        <div class="d-flex flex-column text-right">
                                            {{ $appointment->allServices }}
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-between align-items-center mx-3">
                                        <div>
                                            <span class="text-uppercase font-weight-bold sr-only">Options</span>
                                        </div>
                                        <div class="d-flex flex-column text-right">
                                            <span>
                                                @can('appointments_update')
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        wire:click.prevent="edit({{ $appointment }})"
                                                        title="Edit"
                                                        class="btn btn-sm btn-link border border-0 icon">
                                                            <i class="fas fa-edit text-muted"></i>
                                                    </a>
                                                @endcan
                                                @can('appointments_destroy')
                                                    <a href="javascript:void(0)"
                                                        wire:click="destroy({{$appointment->id}})"
                                                        title="Delete"
                                                        class="btn btn-sm btn-link border border-0 icon" style="width: 20px">
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
                                        {{-- @include('common.datatable-feedback') --}}
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
        <div class="card-body p-0 d-none d-md-block" {{-- style="display: block;" --}}>
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
                            <th>
                                <span class="sr-only">Edit</span>
                            </th>
                            <th>
                                <span class="sr-only">Delete</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr id="rowcheck{{$this->pageTitle}}{{ $appointment->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                <td width="10px">
                                    <div class="icheck-pomegranate">
                                        <input type="checkbox"
                                        id="check{{$this->pageTitle}}{{$appointment->id}}"
                                        wire:model.defer="selected"
                                        value="{{$appointment->id}}"
                                        onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                        class="counter{{$this->pageTitle}}">
                                        <label class="sr-only" for="check{{$this->pageTitle}}{{$appointment->id}}">Click to check</label>
                                    </div>
                                </td>
                                <td class="{{ $appointment->pass ? 'text-muted' : '' }}">
                                    {{ $appointment->veterinarian->user->name }}
                                </td>

                                <td class="{{ $appointment->pass ? 'text-muted' : '' }}">
                                    {{ $appointment->allServices }}
                                </td>
                                @if($appointment->pass)
                                    <td class="text-center text-muted" colspan="2">
                                        Your appointment has expired.
                                    </td>
                                @else
                                    <td class="text-right">
                                        {{ $appointment->start_time->format('d-m-Y') }}
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $appointment->start_time->format('H:i') }} hrs
                                    </td>
                                @endif
                                <td width="1px">
                                    @can('appointments_update')
                                        <a href="javascript:void(0)"
                                            data-toggle="modal"
                                            wire:click.prevent="edit({{ $appointment }})"
                                            title="Edit"
                                            class="btn btn-sm btn-link border border-0 icon">
                                                <i class="fas fa-edit text-muted"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td width="1px">
                                    @can('appointments_destroy')
                                        <a href="javascript:void(0)"
                                            wire:click="destroy({{$appointment->id}})"
                                            title="Delete"
                                            class="btn btn-sm btn-link border border-0 icon" style="width: 20px">
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
        @if(count($appointments))
            @if($appointments->hasPages())
                <div class="card-footer clearfix" style="display: block;">
                    <div class="mailbox-controls">
                        <div class="float-right pagination pagination-sm">
                            <div class="ml-4">
                                {{ $appointments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <!-- /.card-footer -->

        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
        <div wire:loading.class="overlay dark" wire:target="destroy">
        </div>
    </div>

    <!-- Button trigger modal -->
    @include('livewire.forms.form-appointments')
</div>

{{-- Flatpickr --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

<script type="text/javascript">
    window.addEventListener('deletedAppointment', event => {
        notify(event)
    });

    window.addEventListener('updatedAppointment', event => {
        notify(event)
    });

    window.addEventListener('storedAppointment', event => {
        notify(event)
    });

    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal-appointment', msg =>  {
            $('#modalForm{{$this->pageTitle}}').modal('show')
        });
        window.livewire.on('hide-modal-appointment', msg =>  {
            $('#modalForm{{$this->pageTitle}}').modal('hide')
        });
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

<script>
document.addEventListener('DOMContentLoaded', function(){

    let now = new Date(); // Obtener la fecha y hora actual
    let next_five = new Date(Math.ceil(now.getTime()/300000)*300000); // Hora actual redondeada al siguiente multiplo de 5

    flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: true,
            minDate: 'today',
            minTime: "08:00",
            maxTime: "16:50",
            //maxDate: new Date().fp_incr(14), // 14 days from now
            defaultDate: next_five,
            dateFormat: 'd-m-Y H:i',
            time_24hr: true,
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