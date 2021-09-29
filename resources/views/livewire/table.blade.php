<!--Datatable -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-gradient-primary">
                <h3 class="card-title">List of items</h3>
                <div class="card-tools">

                    <!-- Datatable's filters -->
                        <!--COMMENT: cuando se va a poner solo un elemento en el row, recordar modificar la columna a un ancho de 12 collumnas -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm m-1">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect02">Show</label>
                                </div>
                                <select wire:model="paginate" wire:change="resetPagination" class="custom-select" id="inputGroupSelect02">
                                    <option disabled>Choose...</option>
                                    <option value="10">10 items</option>
                                    <option selected value="25">25 items</option>
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
                <table class="table table-head-fixed table-hover">
                    <thead>
                        <tr class="text-uppercase">
                            <th {{--wire:click="order('name')"--}}>
                                Role
                                {{--
                                @if($sort == 'name')
                                    @if($direction == 'asc')
                                        <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="text-xs text-muted fas fa-sort"></i>
                                @endif
                                --}}
                            </th>
                            <th {{--wire:click="order('email')"--}}>
                                Contact
                                {{--
                                @if($sort == 'email')
                                    @if($direction == 'asc')
                                        <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="text-xs text-muted fas fa-sort"></i>
                                @endif
                                --}}
                            </th>
                            <th {{--wire:click="order('status')"--}}>
                                Status
                                {{--
                                @if($sort == 'status')
                                    @if($direction == 'asc')
                                        <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="text-xs text-muted fas fa-sort"></i>
                                @endif
                                --}}
                            </th>
                            <th colspan="2" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>
                                    {{--<div class="d-flex justify-content-between align-items-center">
                                        <p class="pr-2">
                                            <img class="img-circle shadow shadow-sm"
                                                alt="avatar"
                                                src="{{ $item->profile_photo_url }}"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </p>
                                        <p class="d-flex flex-column font-weight-light text-right text-nowrap">
                                            <span>
                                                {{ $item->name }}
                                            </span>
                                            <span class="text-xs text-uppercase">
                                                <b>{{ $item->user_type }}</b>
                                            </span>
                                        </p>
                                    </div>--}}
                                </td>
                                <td>
                                    {{--
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column font-weight-light text-left">
                                            <span class="text-uppercase ">
                                                <i class="text-muted fas fa-fw fa-phone"></i>
                                                {{ $item->phone }}
                                            </span>
                                            <span></i>
                                                <i class="text-muted fas fa-fw fa-envelope"></i>
                                                {{ $item->email }}
                                            </span>
                                        </p>
                                    </div>
                                    --}}
                                </td>
                                <td>
                                    {{--
                                    <span class="text-uppercase badge badge-{{ $item->status == 'active' ? 'success':'danger'}}">
                                        {{ $item->status}}
                                    </span>
                                    --}}
                                </td>
                                <td width="10px">
                                    {{--
                                    <a href="javascript:void(0)"
                                        data-toggle="modal"
                                        wire:click.prevent="edit({{ $item }})"
                                        title="edit"
                                        class="btn btn-app">
                                            <i class="fas fa-edit"></i> Edit
                                    </a>
                                    --}}
                                </td>
                                <td width="10px">
                                    {{--
                                    <a href="javascript:void(0)"
                                        onclick="confirm('{{ $item->id }}', 'Are you sure you want delete this Item?', 'You won\'t be able to revert this!', 'Item', 'destroy')"
                                        title="Delete"
                                        class="btn btn-app">
                                            <i class="fas fa-trash"></i> Delete
                                    </a>
                                    --}}
                                </td>
                            </tr>
                        @empty
                            <!-- COMMENT: Muestra cuando el componente esta readyToLoad. Cunado el componente por naturaleza no mostrará grandes cantidades de registros, se puede evitar esta validación-->
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
                    <p wire:loading wire:target="loadItems" class="display-4 text-muted pt-3"><i class="fas fa-fw fa-spinner fa-spin"></i></p>
                </div>

                @if(count($items))
                    <div class="ml-4">
                        @if($items->hasPages())
                            {{ $items->links() }}
                        @endif
                    </div>
                @endif
            </div>
              <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>