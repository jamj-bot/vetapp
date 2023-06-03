<div>
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
                        </div>

                        <div class="col-auto">
                            <!-- Add Button -->
                            @can('roles_store')
                                @include('common.add-button')
                            @endcan
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header bg-gradient-fuchsia">
                            <h3 class="card-title">
                                Roles
                            </h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed table-hover text-sm datatable">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th wire:click="order('name')">
                                            Role
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
                                            Created at
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
                                    @forelse($roles as $role)
                                        <tr>
                                            <td>
                                                <p class="d-flex flex-column mb-0">
                                                    <span>
                                                        {{ $role->name }}
                                                    </span>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="d-flex flex-column mb-0">
                                                    {{ $role->created_at->diffForHumans() }}
                                                </p>
                                            </td>
                                            <td width="10px">
                                                @can('roles_update')
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        wire:click.prevent="edit({{ $role }})"
                                                        title="Edit"
                                                        class="btn btn-sm btn-link border border-0 icon">
                                                            <i class="fas fa-edit text-muted"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                            <td width="10px">
                                                @can('roles_destroy')
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="destroy({{ $role->id }})"
                                                        title="Delete"
                                                        class="btn btn-sm btn-link border border-0 icon">
                                                            <i class="fas fa-trash text-muted"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                @include('common.datatable-feedback')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                          <!-- /.card-body -->

                        <!-- card-footer -->
                        @if(count($roles))
                            @if($roles->hasPages())
                                <div class="card-footer clearfix" style="display: block;">
                                    <div class="mailbox-controls">
                                        <div class="float-right pagination pagination-sm">
                                            <div class="ml-4">
                                                {{ $roles->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
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

    @include('livewire.role.form')
</div>


<script type="text/javascript">
    window.addEventListener('stored', event => {
        notify(event)
    });

    window.addEventListener('updated', event => {
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