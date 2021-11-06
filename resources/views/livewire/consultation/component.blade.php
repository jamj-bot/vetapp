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
                        <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">...</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">...</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $pet->user) }}">{{ $pet->user->name }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pets.show', $pet) }}">{{ $pet->name }}</a></li>
                        <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3">
                    <a href="{{ route('admin.pets.show', $pet) }}"
                        class="btn btn-block btn-default mb-3">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        Pet
                    </a>
                    <!-- Button trigger modal -->
                    <button type="button"
                        class="btn bg-gradient-primary btn-block mb-3"
                        data-toggle="modal"
                        data-target="#modalForm">
                       <i class="fas fa-fw fa-plus"></i> Add Consultation
                    </button>

                    <div class="card card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Folders</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item active">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-inbox"></i> Inbox
                                        <span class="badge bg-primary float-right">12</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-envelope"></i> Sent
                                     </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-file-alt"></i> Drafts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-filter"></i> Junk
                                        <span class="badge bg-warning float-right">65</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-trash-alt"></i> Trash
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card card-primary card-outline font-weight-light">
                        <div class="card-header">
                            <h3 class="card-title">About {{ $pet->name }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="fas fa-fw fa-fingerprint mr-1 text-muted"></i>
                                    {{ $pet->code }}
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-fw fa-paw mr-1 text-maroon"></i>
                                    {{ $pet->species->name }} / <span class="font-italic">{{ $pet->species->scientific_name }}</span>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-fw fa-award mr-1 text-lime"></i>
                                    {{ $pet->breed != null ? $pet->breed :  'Unknown or mixed-breed' }}
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-fw fa-venus mr-1 text-lightblue"></i>
                                    {{ $pet->sex }}
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-fw fa-neuter mr-1 text-purple"></i>
                                    {{$pet->neuteredOrSpayed }}

                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-fw fa-birthday-cake mr-1 text-pink"></i>
                                    @if($pet->dob->diffInDays(\Carbon\Carbon::now()) < 59)
                                        {{ $pet->dob->diffInDays(\Carbon\Carbon::now()) }} days old
                                    @elseif($pet->dob->diffInDays(\Carbon\Carbon::now()) >= 60 && $pet->dob->diffInMonths(\Carbon\Carbon::now()) < 24)
                                        {{ $pet->dob->diffInMonths(\Carbon\Carbon::now())}} months old
                                    @elseif($pet->dob->diffInMonths(\Carbon\Carbon::now()) >= 24)
                                        {{ $pet->dob->diffInYears(\Carbon\Carbon::now()) }} years old
                                    @endif
                                     / {{ $pet->dob->format('d-M-y') }}
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-fw fa-hard-hat mr-1 text-warning"></i>
                                    {{ $pet->zootechnical_function }}
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-fw fa-calendar mr-1 text-navy"></i>
                                    Registered {{ $pet->created_at->diffForHumans() }}
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->


                <div class="col-md-9">
                    @if($pet->diseases)
                        <div class="callout callout-warning alert alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5>Pre-existing conditions</h5>
                            {{ $pet->diseases }}
                        </div>
                    @endif
                    @if($pet->allergies)
                        <div class="callout callout-danger alert alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5>Allergies</h5>
                            {{ $pet->allergies }}
                        </div>
                    @endif

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Inbox</h3>

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
                                                <option selected value="10">10 items</option>
                                                <option value="50">50 items</option>
                                                <option value="100">100 items</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @include('common.search')
                                    </div>
                                </div>
                                <!-- /.Datatable filters -->
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body p-0">
                            <div class="mailbox-controls">

                                <!-- Check all button -->
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>
                                <!-- /.btn-group -->

                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <div class="float-right">
                                    1-50/200
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                      <!-- /.btn-group -->
                                </div>
                                <!-- /.float-right -->
                            </div>

                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped font-weight-light">
                                    <tbody>
                                        @forelse($consultations as $consultation)
                                            <tr>
                                                <td>
                                                    <div class="icheck-primary">
{{--                                                         <input type="checkbox" value="" id="check6">
                                                        <label for="check6"></label> --}}
                                                    <a href="javascript:void(0)"
                                                        data-toggle="modal"
                                                        wire:click.prevent="edit({{ $consultation }})"
                                                        title="Edit"
                                                        class="btn btn-sm btn-link border border-0">
                                                            <i class="fas fa-edit text-muted"></i>
                                                    </a>
                                                    </div>
                                                </td>
                                                <td class="mailbox-star">
                                                    @if($consultation->consult_status == 'Closed')
                                                        <i class="fas fa-check-double text-success"></i>
                                                    @else
                                                        <i class="fas fa-exclamation-triangle text-warning" title="{{ $consultation->consult_status }}"></i>
                                                    @endif
                                                    {{-- <a href="#"><i class="fas fa-check-double text-success"></i></a> --}}
                                                </td>
                                                <td class="mailbox-name">{{-- <a href="read-mail.html"> --}}{{ $consultation->user->name }}{{-- </a> --}}
                                                </td>
                                                <td class="mailbox-subject">
                                                    <a href="{{ route('admin.pets.consultations.show', ['pet' => $pet, 'consultation' => $consultation]) }}">
                                                        <b>{{ $consultation->diagnosis }}</b> - {{ $consultation->prognosis }}
                                                    </a>
{{--                                                     <a href="">
                                                        <b>{{ $consultation->diagnosis }}</b> - {{ $consultation->prognosis }}
                                                    </a>
 --}}                                                </td>
                                                <td class="mailbox-attachment">
                                                    <i class="fas fa-paperclip text-muted"></i>
                                                    <i class="fas fa-images text-muted"></i>
                                                </td>
                                                <td class="mailbox-date"><small>{{ $consultation->updated_at->diffForHumans() }}</small></td>
                                            </tr>
                                        @empty
                                            <!-- COMMENT: Muestra cuando el componente esta readyToLoad -->
                                            @if($readyToLoad == true)
                                                <tr>
                                                    <td colspan="6">
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
                                <!-- /.table -->

                                <!-- COMMENT: Muestra sppiner cuando el componente no está readyToLoad -->
                                <div class="d-flex justify-content-center">
                                    <p wire:loading wire:target="loadItems" class="display-4 text-muted pt-3"><i class="fas fa-fw fa-spinner fa-spin"></i></p>
                                </div>

                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                        <!-- /.card-body -->


                        <div class="card-footer p-0">

                            <div class="mailbox-controls">
                                <!-- Check all button -->
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                                    <i class="far fa-square"></i>
                                </button>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>
                                <!-- /.btn-group -->

                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </button>

                                <div class="float-right pagination pagination-sm">
                                    @if(count($consultations))
                                        <div class="ml-4">
                                            @if($consultations->hasPages())
                                                {{ $consultations->links() }}
                                            @endif
                                        </div>
                                    @endif
{{--                               1-50/200
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div> --}}
                                    <!-- /.btn-group -->
                                </div>
                                <!-- /.float-right -->
                            </div>
                        </div>

                        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
                        <div wire:loading.class="overlay dark" wire:target="store, update, destroy">
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('livewire.consultation.form')
</div>


<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#ckeditor' ), {
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading4', view: 'h4', title: 'Title', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Subtitle', class: 'ck-heading_heading5' }
                ]
            },
            toolbar: ['undo', 'redo', '|', 'heading', 'bold', 'italic', '|', 'numberedList', 'bulletedList' ],

        } )
        .then(function(ckeditor){
            ckeditor.model.document.on('change:data', () => {
                document.querySelector("#textareaProblemStatement").value = ckeditor.getData();
            })
        })
        .catch( error => {
            console.error( error );
        } );
</script>


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

        window.livewire.on('reset-ckeditor', msg =>  {
            // buscar la manera de resetear el textarea usado por el ck editor porque de esta manera no se puede :(
            document.getElementById("ckeditor").value = "";
        });
    });
</script>

