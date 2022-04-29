<div wire:init="loadItems">
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">{{ $pageTitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">Home</a></li>
                      <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Buttons -->
            <div class="form-row d-flex justify-content-end">
                <div class="form-group col-md-3">
                    @can('parasiticides_store')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn bg-gradient-primary btn-block shadow" data-toggle="modal" data-target="#modalForm">
                           <i class="fas fa-fw fa-plus"></i> Add Parasiticide
                        </button>
                    @endcan
                </div>
            </div>


            <!--Datatable -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gradient-primary">
                            <h3 class="card-title">Index</h3>
                            <div class="card-tools">

                                <!-- Datatable's filters -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm m-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect02">Show</label>
                                            </div>
                                            <select wire:model="paginate" wire:change="resetPagination" class="custom-select" id="inputGroupSelect02">
                                                <option disabled>Choose...</option>
                                                <option value="10">10 items</option>
                                                <option value="25">25 items</option>
                                                <option selected value="50">50 items</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @include('common.search')
                                    </div>
                                </div>
                                <!-- /.Datatable filters -->
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed table-hover text-sm">
                                <thead>
                                    <tr class="text-uppercase text-sm text-nowrap">
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
                                        <th wire:click="order('manufacturer')">
                                            Manufacturer

                                            @if($sort == 'manufacturer')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th {{--wire:click="order('target_species')"--}}>
                                            Target species

{{--                                             @if($sort == 'target_species')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif --}}
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
                                            <span class="sr-only">More...</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($parasiticides as $parasiticide)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                <p class="d-flex flex-column font-weight-light mb-0">
                                                    {{ $parasiticide->name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column font-weight-light mb-0">
                                                    {{ $parasiticide->manufacturer }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column font-weight-light mb-0">
                                                    {{-- <ul class="list-inline font-weight-light text-sm"> --}}
                                                        @foreach($parasiticide->species as $item )
                                                            {{-- <li class="list-inline-item"> --}}{{ $item->name }}.{{-- </li> --}}
                                                        @endforeach
                                                    {{-- </ul> --}}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column font-weight-light mb-0">
                                                    {{ $parasiticide->type }}
                                                </p>
                                            </td>
                                            <td>
                                                <i class="fas fa-arrows-alt-v"></i>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body d-none">
                                            <td colspan="5">
                                                <div style="display: none;">
                                                    <dl class="row pl-3 pr-3 font-weight-light">
                                                        <dt class="col-sm-3 text-uppercase">Description</dt>
                                                        <dd class="col-sm-9">{{ $parasiticide->description }}</dd>
                                                        <dt class="col-sm-3 text-uppercase">Dose</dt>
                                                        <dd class="col-sm-8">{{ $parasiticide->dose }}</dd>

                                                        <dt class="col-sm-3 text-uppercase">Route of administration</dt>
                                                        <dd class="col-sm-9">{{ $parasiticide->administration }}</dd>
                                                        <dt class="col-sm-3 text-uppercase">Primary application</dt>
                                                        <dd class="col-sm-9">{{ $parasiticide->primary_doses }} dosis. {{ $parasiticide->primary_application }}</dd>
                                                        <dt class="col-sm-3 text-uppercase">Reapplication interval</dt>
                                                        <dd class="col-sm-9">{{ $parasiticide->reapplication_doses }} dosis. {{ $parasiticide->reapplication_interval }}</dd>
                                                        <dd class="col-sm-9 offset-sm-3">
                                                            @can('parasiticides_update')
                                                                <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    wire:click.prevent="edit({{ $parasiticide }})"
                                                                    title="Edit"
                                                                    class="btn btn-sm btn-link border border-1" style="width: 50px">
                                                                        <i class="fas fa-edit text-muted"></i>
                                                                </a>
                                                            @endcan
                                                            @can('parasiticides_destroy')
                                                                <a href="javascript:void(0)"
                                                                    onclick="confirm('{{ $parasiticide->id }}', 'Are you sure you want delete this Item?', 'You won\'t be able to revert this!', 'Item', 'destroy')"
                                                                    title="Delete"
                                                                    class="btn btn-sm btn-link border border-1" style="width: 50px">
                                                                        <i class="fas fa-trash text-muted"></i>
                                                                </a>
                                                            @endcan
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- COMMENT: Muestra cuando el componente esta readyToLoad -->
                                        @if($readyToLoad == true)
                                            <tr>
                                                <td colspan="5">
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
                                <p wire:loading wire:target="loadItems" class="display-4 text-muted pt-3">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i>
                                </p>
                            </div>

                            {{-- aquí va el paginador --}}
                        </div>
                        <!-- /.card-body -->


                        <div class="card-footer clearfix" style="display: block;">
                            @if(count($parasiticides))
                                <div class="ml-4">
                                    @if($parasiticides->hasPages())
                                        {{ $parasiticides->links() }}
                                    @endif
                                </div>
                            @endif
                        </div>
                        <!-- /.card-footer -->

                        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
                        <div wire:loading.class="overlay dark" wire:target="store, update, destroy">
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @include('livewire.parasiticide.form')
</div>

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
            $('#modalForm').modal('show')
        });
        window.livewire.on('hide-modal', msg =>  {
            $('#modalForm').modal('hide')
        });
    });
</script>