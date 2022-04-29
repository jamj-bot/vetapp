<div wire:init="loadItems">
    <!-- Datatable's filters -->
    <div class="row mb-2 mr-1">
        <div class="col-md-4">
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
        <div class="col-md-4">
            @include('common.search')
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm m-1">
                @can('dewormings_store')
                    <!-- Button trigger modal -->
                    <button type="button" class="btn bg-gradient-primary btn-sm btn-block shadow" data-toggle="modal" data-target="#modalFormDewormings">
                       <i class="fas fa-fw fa-plus"></i> Add deworming
                    </button>
                @endcan
            </div>
        </div>
    </div>
    <!-- /.Datatable filters -->

    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">
                Deworming Schendule
            </h3>

            <div class="card-tools">
                <!-- Maximize Button -->
                <button type="button" class="btn btn-tool pt-3" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0 table-hover text-sm">
                    <thead>
                        <tr>
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
                                Duration <br> <span class="text-xs text-muted">Withdrawal period </span>
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
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        @if($deworming->dose_number/$deworming->doses_required*100 >= 100)
                                            <i class="fas fa-clipboard-check text-success mr-2"></i>
                                        @else
                                            <i class="fas fa-clipboard text-muted mr-2"></i>
                                        @endif
                                        <p class="d-flex flex-column font-weight-light text-left text-sm text-nowrap mb-0">
                                            <span class="text-uppercase">
                                                {{ $deworming->name}}
                                            </span>
                                            <span>
                                                {{ $deworming->type }}
                                            </span>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <p class="d-flex flex-column font-weight-light text-left text-sm text-nowrap mb-0">
                                            <span class="text-uppercase ">
                                                {{ $deworming->duration}}
                                            </span>
                                            <span>
                                                {{ $deworming->withdrawal_period }}
                                            </span>
                                        </p>
                                    </div>
                                </td>
                                <td class="text-nowrap font-weight-light">
                                    {{ $deworming->updated_at->format('d-M-y h:i:s') }}
                                </td>
{{--                                 <td class="text-nowrap font-weight-light">
                                    @if($deworming->done)
                                        {{ $deworming->done->format('d-M-y') }}
                                    @endif
                                </td> --}}
                                <td width="10px">
                                    @can('dewormings_update')
                                        <div class="btn-group-vertical">
                                            <button class="btn btn-xs btn-default"wire:click="administerParasiticide({{$deworming}}, 'increment')" wire:loading.attr="disabled" wire:target="administerParasiticide" {{ $deworming->dose_number >= $deworming->doses_required ? 'disabled' : '' }}>
                                                <i class="fas fa-fw fa-caret-up"></i>
                                            </button>
                                            <button class="btn btn-xs btn-default"wire:click="administerParasiticide({{$deworming}}, 'decrement')" wire:loading.attr="disabled" wire:target="administerParasiticide" {{ $deworming->dose_number <= 1 ? 'disabled' : '' }}>
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
                                            class="btn btn-sm btn-link border border-0">
                                                <i class="fas fa-edit text-muted"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('dewormings_destroy')
                                        <a href="javascript:void(0)"
                                            onclick="confirm('{{$deworming->id}}', 'Are you sure you want delete this deworming?', 'You won\'t be able to revert this!', 'Deworming', 'destroyDeworming')"title="Delete"
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

{{--             <div class="mailbox-controls with-border text-center">
                <a href="{{ route('admin.pets.vaccinations.export', ['pet' => $pet]) }}"
                    class="btn btn-default btn-sm"
                    target="_blank"
                    rel="noopener"
                    title="Print">
                    <i class="far fa-fw fa-file-pdf"></i> Export
                </a>
            </div> --}}
            <!-- /.mailbox-controls -->
        </div>
        <!-- /.card-footer -->

        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
        <div wire:loading.class="overlay dark" wire:target="apply, update, destroyDeworming, administerParasiticide">
        </div>

    </div>


    <!-- Add and edit vaccinations -->
    @include('livewire.forms.form-dewormings')

    <!-- Apply vaccinations -->
    {{-- @include('livewire.forms.form-apply-vaccinations') --}}

</div>

<script>
    // window.addEventListener('applied', event => {
    //     notify(event)
    // });
    // window.addEventListener('undo-applied', event => {
    //     notify(event)
    // });
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
            $('#modalFormDewormings').modal('show')
        });
        window.livewire.on('hide-modal-deworming', msg =>  {
            $('#modalFormDewormings').modal('hide')
        });
        // window.livewire.on('show-modal-apply', msg =>  {
        //     $('#modalFormApply').modal('show')
        // });
        // window.livewire.on('hide-modal-apply', msg =>  {
        //     $('#modalFormApply').modal('hide')
        // });
    });
</script>