<div wire:init="loadItems()">
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">{{ $pageTitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                      <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid ">

            <!-- Buttons -->
            <div class="form-row d-flex justify-content-end">
                <div class="form-group col-md-3">
                    @can('trash_restore')
                        <button type="button" {{ count($users) < 1 ? 'disabled' : ''}}
                            class="btn bg-gradient-secondary btn-block shadow"
                            wire:click.prevent="restore"
                            title="Restore all users">
                           <i class="fas fa-fw fa-recycle"></i>
                                Restore all users
                            <i wire:loading wire:target="restore" class="fas fa-spinner fa-spin"></i>
                        </button>
                    @endcan
                </div>
                <div class="form-group col-md-3">
                    @can('trash_destroy')
                        <button type="button" {{ count($users) < 1 ? 'disabled' : ''}}
                            class="btn bg-gradient-danger btn-block shadow"
                            onclick="confirm(null, 'Are you sure you want permanently delete all users?', 'You won\'t be able to revert this!', 'Users', 'destroy')"
                                title="Empty Recycle Bin">
                           <i class="fas fa-fw fa-trash"></i>
                                Empty Recycle Bin
                        </button>
                    @endcan
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gradient-primary">
                            <h3 class="card-title">Deleted users</h3>
                            <div class="card-tools">
                                
                                <!-- Datatable filters -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group input-group-sm m-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect02">Order by</label>
                                            </div>
                                            <select wire:model="sort" wire:change="resetPagination" class="custom-select" id="inputGroupSelect02">
                                                <option disabled>Choose...</option>
                                                <option selected value="deleted_at">Deleted at</option>
                                                <option value="name">Name</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                  <!-- /.Datatable filters -->


                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="row">
                                @forelse($users as $user)
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="info-box bg-gradient-light shadow">
                                            <span class="info-box-icon bg-gradient-light">
                                                {{-- <i class="far fa-envelope"></i> --}}
                                                <img class="img-rounded elevation-4 shadow-sm"
                                                    alt="avatar"
                                                    src="{{ $user->profile_photo_url }}"
                                                    style="width: 55px; height: 55px; object-fit: cover;">
                                            </span>

                                            <div class="info-box-content text-sm font-weight-light d-inline-block text-truncate">
                                                <span class="info-box-text" title="{{ $user->name }}">{{ $user->name }}</span>
                                                <span class="info-box-number">{{ $user->deleted_at->diffForHumans() }}</span>
                                            </div>

                                            <div>
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-light btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-fw fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <!-- Dropdown menu links -->
                                                        @can('trash_restore')
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)"
                                                                wire:click.prevent="restore({{ $user->id }})"
                                                                title="Restore">
                                                                Restore
                                                            </a>
                                                        @endcan
                                                        @can('trash_destroy')
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)"
                                                                onclick="confirm('{{ $user->id }}', 'Are you sure you want delete this user?', 'You won\'t be able to revert this!', 'User', 'destroy')"
                                                                title="Permanently Delete">
                                                                Permanently Delete
                                                            </a>
                                                        @endcan
                                                     </div>
                                                </div>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <!-- /.col -->
                                @empty
                                    @if($readyToLoad == true)
                                        <!-- COMMENT: Muestra 'Empty' cuando el componente está readyToLoad y no hay items en DB -->
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
                                    @endif
                                @endforelse
                            </div>

                            <!-- COMMENT: Muestra un sppiner cuando el componente no está readyToLoad-->
                             <div class="d-flex justify-content-center">
                                <p wire:loading wire:target="loadItems" class="display-4 text-muted pt-3"><i class="fas fa-fw fa-spinner fa-spin"></i></p>
                            </div>
                        </div>
                        <!-- /.card-body -->


                        @if(count($users))
                            <div class="card-footer">
                                {{$users->links()}}
                            </div>
                        @endif
                        <!-- /.card-footer -->

                        <!-- COMMENT: muestra overlay cuando se llama a los método restore y delete -->
                        <div wire:loading.class="overlay dark" wire:target="restore">
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    window.addEventListener('restored', event => {
        notify(event)
    });
</script>