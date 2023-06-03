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
                            @include('common.destroy-multiple-and-undo-buttons')
                        </div>

                        <div class="col-auto">
                            <!-- Add Button -->
                            @can('users_store')
                                @include('common.add-button')
                            @endcan
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-gradient-purple">
                            <h3 class="card-title">
                               @if($this->select_page)
                                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                                @else
                                    <span id="dynamicText{{$this->pageTitle}}">Veterinarians</span>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center mx-1">
                                                    <div>
                                                        <img class="img-fluid rounded-circle elevation-2 shadow"
                                                            loading="lazy"
                                                            src="{{ $user->profile_photo_url }}"
                                                            style="width: 40px; height: 40px; object-fit: cover;"
                                                            alt="{{ $user->name }}">

                                                        <!-- Session message -->
                                                        @if (session()->has('user_id') && session('user_id') == $user->id)
                                                            @if (session()->has('message'))
                                                                <span x-data="{ show: true }"
                                                                    x-show="show"
                                                                    x-init="setTimeout(() => show = false, 10000)"
                                                                    x-transition.duration.1500ms
                                                                    class="ml-2 text-muted text-xs">
                                                                    {{ session('message') }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                        <!-- ./ Session message -->
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span class="">
                                                            @can('users_show')
                                                                <a href="{{ route('admin.veterinarians.show', $user) }}"
                                                                    class="font-weight-bold" title="{{ $user->name }}'s profile">
                                                                    {{ $user->name }}
                                                                </a>
                                                            @else
                                                                {{ $user->name }}
                                                            @endcan
                                                        </span>
                                                        <span class="text-xs text-uppercase">
                                                            DGP {{ $user->veterinarian->dgp }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body d-none">
                                            <td colspan="1">
                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Contact</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span class="">
                                                            {{ $user->phone }}
                                                        </span>
                                                        <span class="">
                                                            {{ $user->email }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Status</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span class="text-uppercase badge badge-{{ $user->status == 'active' ? 'success':'danger'}}">
                                                            {{ $user->status }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold sr-only">Options</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right ml-2">
                                                        <span>
                                                            @can('user_update')
                                                                <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    wire:click.prevent="edit({{ $user }})"
                                                                    title="Edit"
                                                                    class="btn btn-sm btn-link border border-0" style="width: 50px">
                                                                        <i class="fas fa-edit text-muted"></i>
                                                                </a>
                                                            @endcan
                                                            @can('users_destroy')
                                                                <a href="javascript:void(0)"
                                                                    data-toggle="modal"
                                                                    wire:click.prevent="destroy({{ $user->id }})"
                                                                    title="Delete"
                                                                    class="btn btn-sm btn-link border border-0 icon">
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
                                            <div class="icheck-wisteria">
                                                <input type="checkbox"
                                                id="checkAll{{$this->pageTitle}}"
                                                wire:model="select_page"
                                                wire:loading.attr="disabled">
                                                <label class="sr-only" for="checkAll{{$this->pageTitle}}">Click to check all items</label>
                                            </div>
                                        </th>
                                        <th wire:click="order('name')">
                                            Veterinarian
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
                                        <th wire:click="order('email')">
                                            Contact
                                            @if($sort == 'email')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th wire:click="order('status')">
                                            Status
                                            @if($sort == 'status')
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
                                    @forelse($users as $user)
                                        <tr id="rowcheck{{$this->pageTitle}}{{ $user->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                            <td width="10px">
                                                <div class="icheck-wisteria">
                                                    <input type="checkbox"
                                                    id="check{{$this->pageTitle}}{{$user->id}}"
                                                    wire:model.defer="selected"
                                                    value="{{$user->id}}"
                                                    onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                                    class="counter{{$this->pageTitle}}">
                                                    <label class="sr-only" for="check{{$this->pageTitle}}{{$user->id}}">Click to check</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="pr-2 mb-0">

                                                        <img class="{{-- profile-user-img --}} img-circle elevation-3"
                                                            loading="lazy"
                                                            alt="user profile photo"
                                                            src="{{ $user->profile_photo_url }}"
                                                            style="width: 40px; height: 40px; object-fit: cover;">

                                                        <!-- Session message -->
                                                        @if (session('user_id') == $user->id)
                                                            @if (session()->has('message'))
                                                                <span x-data="{ show: true }"
                                                                    x-show="show"
                                                                    x-init="setTimeout(() => show = false, 5000)"
                                                                    x-transition.duration.1500ms
                                                                    class="ml-2 text-muted text-xs">
                                                                    {{ session('message') }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                        <!-- ./ Session message -->
                                                    </p>
                                                    <p class="d-flex flex-column text-right mb-0">
                                                        <span>
                                                            @can('user_profile_show')
                                                                <a href="{{ route('admin.veterinarians.show', $user) }}"
                                                                    class="text-uppercase font-weight-bold" title="{{ $user->name }}'s profile">
                                                                    {{ $user->name }}
                                                                </a>
                                                            @else
                                                                <span class="text-uppercase font-weight-bold"> {{ $user->name }}</span>
                                                            @endcan
                                                        </span>
                                                        <span class="text-xs text-uppercase">
                                                            DGP {{ $user->veterinarian->dgp }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="d-flex flex-column text-left mb-0">
                                                        <span class="text-uppercase ">
                                                            <i class="text-muted fas fa-fw fa-phone"></i>
                                                            {{ $user->phone }}
                                                        </span>
                                                        <span>
                                                            <i class="text-muted fas fa-fw fa-envelope"></i>
                                                            {{ $user->email }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-uppercase badge badge-{{ $user->status == 'active' ? 'success':'danger'}}">
                                                    {{ $user->status}}
                                                </span>
                                            </td>
                                            <td width="10px">
                                                @can('users_update')
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        wire:click.prevent="edit({{ $user }})"
                                                        title="Edit"
                                                        class="btn btn-sm btn-link border border-0 icon">
                                                            <i class="fas fa-edit text-muted"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                            <td width="10px">
                                                @can('users_destroy')
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="destroy({{ $user->id }})"
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
                                                <td colspan="6">
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
                          <!-- /.card-body -->


                        <!-- card-footer -->
                        @if(count($users))
                            @if($users->hasPages())
                                <div class="card-footer clearfix" style="display: block;">
                                    <div class="mailbox-controls">
                                        <div class="float-right pagination pagination-sm">
                                            <div class="ml-4">
                                                {{ $users->links() }}
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
        </div><!-- /.container-fluid -->
    </section>
    @include('livewire.user.form')
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    window.addEventListener('updated', event => {
        notify(event)
    });
    window.addEventListener('stored', event => {
        notify(event)
    });

    window.addEventListener('deleted', event => {
        notify(event)
    });

    window.addEventListener('destroy-error', event => {
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
    });
</script>