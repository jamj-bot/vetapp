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

            <!-- Datatable's filters when screen < md-->
            @include('common.datatable-filters-smaller-md')

            <!-- Datatable's filters when screen > md-->
            @include('common.datatable-filters-wider-md')

            <!--Datatable -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gradient-primary">
                            <h3 class="card-title">Index</h3>
                            <div class="card-tools">
                            </div>
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
                                    @forelse($pets as $pet)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center mx-1">
                                                    <div>
                                                        <img class="img-circle elevation-2 shadow border border-2"
                                                            loading="lazy"
                                                            src="{{$pet->pet_profile_photo ? asset('storage/pet-profile-photos/' . $pet->pet_profile_photo) : 'https://ui-avatars.com/api/?name='.$pet->name.'&color=FFF&background=random&size=128'}}"
                                                            style="width: 48px; height: 48px; object-fit: cover; background: antiquewhite;"
                                                            alt="{{ $pet->name }}">
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span class="text-uppercase">
                                                            @can('pets_show')
                                                                <a href="{{ route('admin.pets.show', $pet) }}"
                                                                    class="font-weight-bold" title="{{ $pet->name }}'s profile">
                                                                    {{ $pet->name }}
                                                                </a>
                                                            @else
                                                                {{ $pet->name }}
                                                            @endcan
                                                        </span>
                                                        <span class="">
                                                            @can('pets_show')
                                                                @if($pet->name == null)
                                                                    <a href="{{ route('admin.pets.show', $pet) }}"
                                                                        class="font-weight-bold" title="{{ $pet->code }}'s profile">
                                                                        {{ $pet->code }}
                                                                    </a>
                                                                @else
                                                                 {{ $pet->code }}
                                                                @endif
                                                            @else
                                                                {{ $pet->code }}
                                                            @endcan
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body d-none">
                                            <td colspan="1">
                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Breed</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span class="{{ !$pet->breed ? 'text-muted' : '' }}">
                                                            {{ $pet->breed ? $pet->breed : 'Crossbreed / undetermined' }}
                                                        </span>
                                                        <span class="{{ !$pet->zootechnical_function ? 'text-muted' : '' }}">
                                                            {{ $pet->zootechnical_function ? $pet->zootechnical_function : 'Undetermined function' }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Species</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span class="">
                                                            {{ $pet->common_name }}
                                                        </span>
                                                        <span class="font-italic">
                                                            {{ $pet->scientific_name }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Status</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span class="text-uppercase badge badge-{{ $pet->status == 'Alive' ? 'success':'danger'}}">
                                                            {{ $pet->status }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mx-3" style="display: none;">
                                                    <div>
                                                        <span class="text-uppercase font-weight-bold">Owner</span>
                                                    </div>
                                                    <div class="d-flex flex-column text-right">
                                                        <span>
                                                            {{ $pet->user_name }}
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
                                    {{-- <i class="fas fa-fw fa-spinner fa-spin"></i> --}}
                                    <span class="loader"></span>
                                </p>
                            </div>
                        </div>
                        <!-- /. Datatable's when screen < md (card-body) -->

                        <!-- Datatable's when screen > md (card-body)-->
                        <div class="card-body table-responsive p-0 d-none d-md-block">
                            <table class="table table-head-fixed table-hover text-sm">
                                <thead>
                                    <tr class="text-uppercase">
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
                                        <th wire:click="order('breed')" class="text-right">
                                            Breed
                                            @if($sort == 'breed')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th wire:click="order('common_name')">
                                            Species
                                            @if($sort == 'common_name')
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
                                        <th wire:click="order('user_name')">
                                            Owner
                                            @if($sort == 'user_name')
                                                @if($direction == 'asc')
                                                    <i class="text-xs text-muted fas fa-sort-alpha-up-alt"></i>
                                                @else
                                                    <i class="text-xs text-muted fas fa-sort-alpha-down-alt"></i>
                                                @endif
                                            @else
                                                <i class="text-xs text-muted fas fa-sort"></i>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pets as $pet)
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="pr-2 mb-0">
                                                        <img class="img-circle elevation-2 shadow border border-2"
                                                            loading="lazy"
                                                            src="{{$pet->pet_profile_photo ? asset('storage/pet-profile-photos/' . $pet->pet_profile_photo) : 'https://ui-avatars.com/api/?name='.$pet->name.'&color=FFF&background=random&size=128'}}"
                                                            style="width: 48px; height: 48px; object-fit: cover; background: antiquewhite;"
                                                            alt="{{ $pet->name }}">
                                                    </p>
                                                    <p class="d-flex flex-column text-right mb-0">
                                                        <span class="text-uppercase">
                                                            @can('pets_show')
                                                                <a href="{{ route('admin.pets.show', $pet) }}"
                                                                    class="font-weight-bold" title="{{ $pet->name }}'s profile">
                                                                    {{ $pet->name }}
                                                                </a>
                                                            @else
                                                                {{ $pet->name }}
                                                            @endcan
                                                        </span>
                                                        <span class="">
                                                            @can('pets_show')
                                                                @if($pet->name == null)
                                                                    <a href="{{ route('admin.pets.show', $pet) }}"
                                                                        class="font-weight-bold" title="{{ $pet->code }}'s profile">
                                                                        {{ $pet->code }}
                                                                    </a>
                                                                @else
                                                                 {{ $pet->code }}
                                                                @endif
                                                            @else
                                                                {{ $pet->code }}
                                                            @endcan
                                                        </span>
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column text-left mb-0 text-right">
                                                    <span class="{{ !$pet->breed ? 'text-muted' : '' }}">
                                                        {{ $pet->breed ? $pet->breed : 'Crossbreed / undetermined' }}
                                                    </span>
                                                    <span class="{{ !$pet->zootechnical_function ? 'text-muted' : '' }} text-right">
                                                        {{ $pet->zootechnical_function ? $pet->zootechnical_function : 'Undetermined function' }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column text-left mb-0">
                                                    <span class="">
                                                        {{ $pet->common_name }}
                                                    </span>
                                                    <span class="font-italic">
                                                        {{ $pet->scientific_name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-uppercase badge badge-{{ $pet->status == 'Alive' ? 'success':'danger'}}">
                                                    {{ $pet->status }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $pet->user_name }}
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- COMMENT: Muestra cuando el componente esta readyToLoad -->
                                        @if($readyToLoad == true)
                                            <tr>
                                                <td colspan="5">
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
                        <!-- /. Datatable's when screen > md (card-body) -->

                        <!-- card-footer -->
                        @if(count($pets))
                            @if($pets->hasPages())
                                <div class="card-footer clearfix" style="display: block;">
                                    <div class="mailbox-controls">
                                        <div class="float-right pagination pagination-sm">
                                            <div class="ml-4">
                                                {{ $pets->links() }}
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
</div>



<script>
    window.addEventListener('updated', event => {
        notify(event)
    });
    window.addEventListener('stored', event => {
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