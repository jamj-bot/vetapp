<div wire:init="loadItems">
    <!-- Datatable's filters when screen < md-->
    @include('common.datatable-filters-smaller-md')

    <!-- Datatable's filters when screen > md-->
    @include('common.datatable-filters-wider-md')

    <!-- Datatable's buttons -->
    <div class="d-flex justify-content-between mb-3">
        <div class="col-auto">
            <!-- Undo and destroy Buttons -->
            @can('dewormings_destroy')
                @include('common.destroy-multiple-and-undo-buttons')
            @endcan
        </div>

        <div class="col-auto">
            <!-- Add Button -->
            @can('dewormings_store')
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

    <div class="card card-outline card-lime">
        <div class="card-header border-transparent">
            <h3 class="card-title">
                @if($this->select_page)
                    <span id="dynamicTextDewormings">{{ count($this->selected) }} item(s) selected</span>
                @else
                    <span id="dynamicTextDewormings">Deworming Schedule</span>
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

        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0 table-hover text-sm datatable">
                    <thead>
                        <tr>
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
                                Duration <span class="text-muted">& Withdrawal period </span>
                            </th>
                            <th wire:click="order('updated_at')">
                                Last update
                                @if($sort == 'updated_at')
                                    @if($direction == 'asc')
                                        <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="text-xs text-muted fas fa-sort"></i>
                                @endif
                            </th>
                            <th colspan="2">
                                Progress
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
                        @forelse($dewormings as $deworming)
                            <tr id="rowcheckDewormings{{ $deworming->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                <td width="10px">
                                    <div class="icheck-emerland">
                                        <input type="checkbox"
                                        id="check{{$this->pageTitle}}{{$deworming->id}}"
                                        wire:model.defer="selected"
                                        value="{{$deworming->id}}"
                                        onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                        class="counter{{$this->pageTitle}}">
                                        <label class="sr-only" for="check{{$this->pageTitle}}{{$deworming->id}}">Click to check</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        @if($deworming->dose_number/$deworming->doses_required*100 >= 100)
                                            <i class="fas fa-clipboard-check text-success mr-2"></i>
                                        @else
                                            <i class="fas fa-clipboard text-muted mr-2"></i>
                                        @endif
                                        <p class="d-flex flex-column text-left text-sm text-nowrap mb-0">
                                            <span class="text-uppercase font-weight-bold">
                                                <a href="javascript:void(0)"
                                                    class="text-orange"
                                                    data-toggle="modal"
                                                    data-target="#modalDewormingsDetails"
                                                    onclick="setValuesModalDewormingApply('{{$deworming->name}}', '{{$deworming->type_1}}', '{{$deworming->manufacturer}}', '{{$deworming->dose}}', '{{$deworming->administration}}', '{{$deworming->description}}', '{{$deworming->primary_application}}', '{{$deworming->primary_doses}}', '{{$deworming->reapplication_interval}}', '{{$deworming->reapplication_doses}}')">
                                                    {{ $deworming->name}}
                                                </a>
                                            </span>
                                            <span>
                                                {{ $deworming->type }}
                                            </span>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <p class="d-flex flex-column text-left text-sm text-nowrap mb-0">
                                            <span class="text-uppercase ">
                                                {{ $deworming->duration}}
                                            </span>
                                            <span>
                                                {{ $deworming->withdrawal_period }}
                                            </span>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    {{-- {{ $deworming->updated_at->format('d-M-y h:i:s') }} --}}
                                    <div class="d-flex justify-content-start align-items-center">
                                        <p class="d-flex flex-column text-left text-sm text-nowrap mb-0">
                                            <span class="text-uppercase ">
                                                {{ $deworming->updated_at->format('d-M-y') }}
                                            </span>
                                            <span>
                                                {{ $deworming->updated_at->format('h:i') }} hours
                                            </span>
                                        </p>
                                    </div>
                                </td>
{{--                                 <td class="text-nowrap font-weight-light">
                                    @if($deworming->done)
                                        {{ $deworming->done->format('d-M-y') }}
                                    @endif
                                </td> --}}
                                <td width="10px">
                                    @can('dewormings_update')
                                        <div class="btn-group-vertical">
                                            <button class="btn btn-xs btn-default" wire:click="administerParasiticide({{$deworming}}, 'increment')" wire:loading.attr="disabled" wire:target="administerParasiticide" {{ $deworming->dose_number >= $deworming->doses_required ? 'disabled' : '' }}>
                                                <i class="fas fa-fw fa-caret-up"></i>
                                            </button>
                                            <button class="btn btn-xs btn-default" wire:click="administerParasiticide({{$deworming}}, 'decrement')" wire:loading.attr="disabled" wire:target="administerParasiticide" {{ $deworming->dose_number <= 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-fw fa-caret-down"></i>
                                            </button>
                                        </div>
                                    @endcan
                                </td>
                                <td class="text-xs">
                                    <div class="progress-group">
                                        Dose:
                                        <span class="float-right">
                                            <b>{{ $deworming->dose_number }}</b>/{{ $deworming->doses_required }}
                                        </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar {{ ($deworming->dose_number/$deworming->doses_required)*100 >= 100 ? 'bg-gradient-success' : 'bg-gradient-gray' }}"
                                                style="width: {{ ($deworming->dose_number/$deworming->doses_required)*100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td width="10px">
                                    @can('dewormings_update')
                                        <a href="javascript:void(0)"
                                            data-toggle="modal"
                                            wire:click.prevent="edit({{ $deworming }})"
                                            title="Edit"
                                            class="btn btn-sm btn-link border border-0 icon">
                                                <i class="fas fa-edit text-muted"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('dewormings_destroy')
                                        <a href="javascript:void(0)"
                                            wire:click.prevent="destroy({{ $deworming->id }})"
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
                        <span class="loader"></span>
                    </p>
                </div>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->

        <div class="card-footer clearfix" style="display: block;">

{{--             <div class="d-flex flex-row justify-content-end text-xs font-weight-light">
                <span class="mr-2">
                    <i class="fas fa-square text-success"></i> Applied
                </span>

                <span class="mr-2">
                    <i class="fas fa-square text-warning"></i> Schenduled
                </span>

                <span>
                    <i class="fas fa-square text-danger"></i> Delayed
                </span>
            </div> --}}

            @if(count($dewormings))
                <div class="ml-2">
                    @if($dewormings->hasPages())
                        {{ $dewormings->links() }}
                    @endif
                </div>
            @endif

            <div class="mailbox-controls with-border text-center">
                <a href="{{--route('admin.pets.dewormings.export', ['pet' => $pet]) --}}"
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
        <div wire:loading.class="overlay dark" wire:target="apply, update, destroy, administerParasiticide, destroyMultiple, undoMultiple">
        </div>

    </div>

    <!-- Add and edit vaccinations -->
    @include('livewire.forms.form-dewormings')

    <!-- Apply vaccinations -->
    {{-- @include('livewire.forms.form-apply-vaccinations') --}}

    <div wire:ignore.self class="modal fade" id="modalDewormingsDetails" tabindex="-1" role="dialog" aria-labelledby="modalDewormingsDetailsLabel" data-backdrop="static" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDewormingsDetailsLabel">
                        <span id="dewormingName"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <dl class="row">
                        <dt class="col-sm-4"><span>Manufacturer</span></dt>
                        <dd class="col-sm-8"><span id="dewormingManufacturer"></span></dd>

                        <dt class="col-sm-4"><span>Type</span></dt>
                        <dd class="col-sm-8"><span id="dewormingType_1"></span></dd>

                        <dt class="col-sm-4"><span>Description</span></dt>
                        <dd class="col-sm-8"><span id="dewormingDescription"></span></dd>

                        <dt class="col-sm-4"><span>Dosage</span></dt>
                        <dd class="col-sm-8"><span id="dewormingDose"></span></dd>

                        <dt class="col-sm-4"><span>Administration</span></dt>
                        <dd class="col-sm-8"><span id="dewormingAdministration"></span></dd>

                        <dt class="col-sm-4"><span>Primary application</span></dt>
                        <dd class="col-sm-8"><span id="dewormingPrimaryApplication"></span></dd>
                        <dd class="col-sm-8 offset-sm-4"><span id="dewormingPrimaryDoses"></span> doses</dd>

                        <dt class="col-sm-4"><span>Reapplication interval</span></dt>
                        <dd class="col-sm-8"><span id="dewormingReapplicationInterval"></span></dd>
                        <dd class="col-sm-8 offset-sm-4"><span id="dewormingReapplicationDoses"></span> doses</dd>
                    </dl>
                </div>

                <div class="modal-footer">
                   <button type="button" class="btn bg-gradient-danger" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    window.addEventListener('deworming-updated', event => {
        notify(event)
    });
    window.addEventListener('deworming-stored', event => {
        notify(event)
    });
    window.addEventListener('deworming-deleted', event => {
        notify(event)
    });

    window.addEventListener('deworming-increment', event => {
        notify(event)
    });
    window.addEventListener('deworming-decrement', event => {
        notify(event)
    });




    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal-deworming', msg =>  {
            $('#modalForm{{$this->pageTitle}}').modal('show')
        });
        window.livewire.on('hide-modal-deworming', msg =>  {
            $('#modalForm{{$this->pageTitle}}').modal('hide')
        });
        // window.livewire.on('show-modal-apply', msg =>  {
        //     $('#modalFormApply').modal('show')
        // });
        // window.livewire.on('hide-modal-apply', msg =>  {
        //     $('#modalFormApply').modal('hide')
        // });
    });


    function setValuesModalDewormingApply(name, type_1, manufacturer, dose, administration, description, primary_application, primary_doses, reapplication_interval,reapplication_doses){

        document.getElementById("dewormingName").textContent = name;
        document.getElementById("dewormingType_1").textContent = type_1;
        document.getElementById("dewormingManufacturer").textContent = manufacturer;
        document.getElementById("dewormingDose").textContent = dose;
        document.getElementById("dewormingAdministration").textContent = administration;
        document.getElementById("dewormingDescription").textContent = description;
        document.getElementById("dewormingPrimaryApplication").textContent = primary_application;
        document.getElementById("dewormingPrimaryDoses").textContent = primary_doses;
        document.getElementById("dewormingReapplicationInterval").textContent = reapplication_interval;
        document.getElementById("dewormingReapplicationDoses").textContent = reapplication_doses;
    }
</script>

