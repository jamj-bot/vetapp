<div wire:init="loadItems">
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">
                        {{ $pet->name != null ? $pet->name : $pet->code }}'s Medical History
                        @if($pet->status == 'Dead')
                            <sup class="font-weight-light">Inactive</sup>
                        @endif
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index')}}"><i class="fas fa-house-user"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users.show', $pet->user) }}">{{ $pet->user->name }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.pets.show', $pet)}}"> {{ $pet->name ? $pet->name:$pet->code}}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $pageTitle}}
                        </li>
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
                    @can('pets_show')
                        <a href="{{ route('admin.pets.show', $pet) }}"
                            class="btn btn-block bg-gradient-primary shadow-sm mb-3">
                            <i class="fas fa-fw fa-dog"></i>
                            Pet's profile
                        </a>
                    @endcan

                    <!-- about card -->
                    @include('common.about-card')
                    <!-- /.card -->
                </div>
                <!-- /.col -->


                <div class="col-md-9">
                    <!-- Alerts -->
                    @include('common.alerts')
                    <!-- /.Alerts -->

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                @if($this->select_page)
                                    <span id="dynamicText{{$this->pageTitle}}">{{ count($this->selected) }} item(s) selected</span>
                                @else
                                    <span id="dynamicText{{$this->pageTitle}}">Consultations</span>
                                @endif
                            </h3>

                            <!-- Datatable's filters -->
                            <div class="card-tools">
                                <!-- Datatable's filters when screen < md-->
                                @include('common.datatable-filters-smaller-md')

                                <!-- Datatable's filters when screen > md-->
                                @include('common.datatable-filters-wider-md')
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body p-0">
                            <!-- Control buttons -->
                            <div class="mailbox-controls">

                                <!-- Datatable's buttons -->
                                <div class="d-flex justify-content-between my-1">
                                    <div class="col-auto d-flex justify-content-center">
                                        <!-- Check all button -->
                                        <div class="icheck-nephritis">
                                            <input type="checkbox"
                                            id="checkAll{{$this->pageTitle}}"
                                            wire:model="select_page"
                                            wire:loading.attr="disabled">
                                            <label class="sr-only" for="checkAll{{$this->pageTitle}}">Click to check all items</label>
                                        </div>

                                        @include('common.destroy-multiple-and-undo-buttons')
                                    </div>
                                    <div class="col-auto">
                                         <div x-data="{
                                                {{-- Enreda la propiedad 'model' y almacena su valor de manera persistente. --}}
                                                filter_consultations:    $persist(@entangle('filter')),
                                            }">
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-default dropdown-toggle shadow-sm border-0" type="button" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-fw fa-filter"></i> {{ $this->filter }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item {{ $this->filter == 'All' ? 'active':'' }}" type="button" wire:click="$set('filter', 'All')">
                                                    Status: All
                                                </button>
                                                <button class="dropdown-item {{ $this->filter == 'In process' ? 'active':'' }}" type="button" wire:click="$set('filter', 'In process')">
                                                    Status: In process
                                                </button>
                                                <button class="dropdown-item {{ $this->filter == 'Closed' ? 'active':'' }}" type="button" wire:click="$set('filter', 'Closed')">
                                                    Status: Closed
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button"
                                            wire:click.prevent="loadDobField()"
                                            onclick="bindTextareas()"
                                            class="btn bg-gradient-success btn-block btn-sm shadow-sm border-0"
                                            data-toggle="modal"
                                            data-target="#modalForm{{$this->pageTitle}}">
                                            <i class="fas fa-fw fa-plus-circle text-light"></i> Add {{ Str::of($this->pageTitle)->singular() }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped datatable">
                                    <tbody>
                                        @forelse($consultations as $consultation)
                                            <tr id="rowcheck{{$this->pageTitle}}{{ $consultation->id }}" class="{{ $this->select_page ? 'table-active text-muted' : ''}}">
                                                <td width="10px">
                                                    <div class="icheck-nephritis">
                                                        <input type="checkbox"
                                                        id="check{{$this->pageTitle}}{{$consultation->id}}"
                                                        wire:model.defer="selected"
                                                        value="{{$consultation->id}}"
                                                        onchange="updateInterface(this.id, '{{$this->pageTitle}}')"
                                                        class="counter{{$this->pageTitle}}">
                                                        <label class="sr-only" for="check{{$this->pageTitle}}{{$consultation->id}}">Click to check</label>
                                                    </div>
                                                </td>
                                                <td class="mailbox-star" title="{{ $consultation->consult_status }}">
                                                    <i class="fas fa-star text-xs {{ $consultation->consult_status == 'Closed' ? 'text-warning' : 'text-muted'}}">
                                                    </i>
                                                </td>
                                                <td class="mailbox-name text-sm text-nowrap" title="{{ $consultation->user->name }}">
                                                    @if( strlen($consultation->user->name) > 18)
                                                        {{ substr($consultation->user->name, 0, 15) }}...
                                                    @else
                                                        {{ $consultation->user->name }}
                                                    @endif
                                                </td>
                                                <td title="{{ $consultation->prognosis }}" class="mailbox-star">
                                                    <span class="fa-stack fa-1x m-0">
                                                        <i class="fas fa-circle fa-stack-2x {{ $consultation->color }}"></i>
                                                        <i class="fas fa-heartbeat fa-stack-1x fa-inverse text-light"></i>
                                                    </span>
                                                </td>
                                                <td class="mailbox-subject text-nowrap">
                                                    <a href="{{ route('admin.pets.consultations.show', ['pet' => $pet, 'consultation' => $consultation]) }}"
                                                        class="text-black">
                                                        {{--  Limita el número de palabras a máximo 5; la primera letra la vuelve mayúscula, el array lo convierte en string separado por comas --}}
                                                        {{Str::words(Str::ucfirst($consultation->diseases->implode('name', '; ')), 4, ' >>>') }}
                                                    </a>
                                                </td>
                                                <td class="mailbox-attachment text-xs text-nowrap">
                                                    @if($consultation->images()->count())
                                                        <i class="fas fa-images text-muted"></i>
                                                    @endif
                                                    @if($consultation->tests()->count())
                                                        <i class="fas fa-paperclip text-muted"></i>
                                                    @endif
                                                </td>
                                                <td class="mailbox-date text-nowrap">
                                                    <small class="text-xs">{{ $consultation->updated_at->diffForHumans() }}</small>
                                                </td>
                                                <td width="10px">
                                                    @can('consultations_update')
                                                        <a href="javascript:void(0)"
                                                            data-toggle="modal"
                                                            wire:click.prevent="edit({{ $consultation }})"
                                                            title="Edit"
                                                            class="btn btn-sm btn-link border border-0 icon" style="width: 50px">
                                                                <i class="fas fa-edit text-muted"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                                <td width="10px">
                                                    @can('consultations_destroy')
                                                        <a href="javascript:void(0)"
                                                            wire:click.prevent="destroy({{ $consultation->id }})"
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
                                                    <td colspan="7">
                                                        @include('common.datatable-feedback')
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- /.table -->

                                <!-- COMMENT: Muestra sppiner cuando el componente no está readyToLoad -->
                                <div class="d-flex justify-content-center">
                                    <p wire:loading wire:target="loadItems" class="display-4 text-muted pt-3">
                                        <span class="loader"></span>
                                    </p>
                                </div>

                            </div>
                            <!-- /.mail-box-messages -->

                            @if(count($consultations) > 10)
                                <!-- Control buttons -->
                                <div class="mailbox-controls">
                                    <!-- Check all button -->
{{--                                     <div class="btn checkbox-toggle icheck-pomegranate ml-2">
                                        <input type="checkbox"
                                        id="checkAll"
                                        wire:model="select_page" {{ !count($consultations) ? 'disabled' : '' }}>
                                        <label class="sr-only" for="checkAll">Click to check all items</label>
                                    </div> --}}
{{--                                     <div class="btn checkbox-toggle icheck-greensea ml-2">
                                        <input type="checkbox"
                                            class=""
                                            id="check2"
                                            wire:model="allConsultationsChecked"
                                            wire:click.prevent="updateAllConsultationsChecked"
                                            name="check2">
                                        <label for="check2" class="sr-only">Check all</label>
                                    </div>
 --}}
{{--                                     <div class="btn-group">
                                        @if($this->filter == 'All')
                                            <!-- Destroy hecked consultations button -->
                                            @can('consultations_delete')
                                                <button type="button" class="btn btn-default btn-sm"
                                                    wire:click.prevent="deleteChecked">
                                                    <span class="d-none d-sm-block">
                                                        <i class="fas fa-fw fa-trash"></i> Delete
                                                    </span>
                                                    <span class="d-block d-sm-none">
                                                        <i class="fas fa-fw fa-trash"></i>
                                                    </span>
                                                </button>
                                            @endcan
                                        @endif

                                        @if($this->filter == 'Trash')
                                            <!-- Delete hecked consultations button -->
                                            @can('consultations_destroy')
                                                <button type="button" class="btn btn-default btn-sm"
                                                    onclick="confirmDestroyConsultations('Are you sure you want destroy this consultations?', 'This action can not be undone!', 'Consultations', 'destroyMultiple')">
                                                    <span class="d-none d-sm-block">
                                                        <i class="fas fa-fw fa-trash text-danger"></i>Destroy
                                                    </span>
                                                    <span class="d-block d-sm-none">
                                                        <i class="fas fa-fw fa-trash text-danger"></i>
                                                    </span>
                                                </button>
                                            @endcan
                                        @endif

                                        @if($this->filter == 'Trash')
                                            <!-- Restore hecked consultations button -->
                                            @can('consultations_restore')
                                                <button type="button" class="btn btn-default btn-sm"
                                                    onclick="confirmRestoreConsultations('Are you sure you want restore this consultations???', 'This action can be undone!', 'Consultations', 'restoreMultiple')">
                                                    <span class="d-none d-sm-block">
                                                        <i class="fas fa-fw fa-history"></i>Restore
                                                    </span>
                                                    <span class="d-block d-sm-none">
                                                        <i class="fas fa-fw fa-history"></i>
                                                    </span>
                                                </button>
                                            @endcan
                                        @endif
                                    </div> --}}
                                    <!-- /.btn-group -->

{{--                                     <div class="float-right">
                                        <!-- Botones para pantallas superior a sm -->
                                        <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
                                            <label class="btn bg-gradient-primary {{ $this->filter == 'All' ? 'active' : '' }}">
                                                <input type="radio" name="options" id="option_b1" autocomplete="off"  wire:click="$set('filter', 'All')">
                                                <i class="fas fa-fw fa-inbox"></i> <span class="font-weight-normal">Active</span>
                                                <span class="ml-1 badge bg-success float-right">
                                                    {{ $consultations_quantity }}
                                                </span>
                                            </label>
                                            <label class="btn bg-gradient-primary {{ $this->filter == 'Trash' ? 'active' : '' }}">
                                                <input type="radio" name="options" id="option_b2" autocomplete="off"  wire:click="$set('filter', 'Trash')">
                                                <i class="fas fa-fw fa-recycle"></i> <span class="font-weight-normal">Recycle</span>
                                                <span class="ml-1 badge bg-danger float-right">
                                                    {{ $deleted_consultations_quantity }}
                                                </span>
                                            </label>
                                        </div>
                                    </div> --}}
                                    <!-- /.btn-group -->
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->

                        <!-- card-footer -->
                        @if(count($consultations))
                            @if($consultations->hasPages())
                                <div class="card-footer p-0">
                                    <div class="mailbox-controls">
                                        <div class="float-right pagination pagination-sm">
                                            <div class="ml-4">
                                                {{ $consultations->links() }}
                                            </div>

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
                            @endif
                        @endif
                        <!-- /.card-footer -->

                        <!-- COMMENT: muestra overlay cuando se llama a los métodos apply, update, destroy-->
                        <div wire:loading.class="overlay dark" wire:target="store, update, destroy, delete, deleteChecked, restore">
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

{{-- <script>
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
            // ckeditor.model.document.on('change:data', () => {
            //     document.querySelector("#textareaProblemStatement").value = ckeditor.getData();
            // })
            ckeditor.model.document.on('change:data', () => {
                @this.set('problem_statement', ckeditor.getData());
            })
        })
        .catch( error => {
            console.error( error );
        } );
</script> --}}

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

    window.addEventListener('destroyed', event => {
        notify(event)
    });

    window.addEventListener('restored', event => {
        notify(event)
    });

    window.addEventListener('deleted-error', event => {
        notify(event)
    });

    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg =>  {
            $('#modalForm{{$this->pageTitle}}').modal('show')
        });

        window.livewire.on('hide-modal', msg =>  {
            $('#modalForm{{$this->pageTitle}}').modal('hide')
        });

        // window.livewire.on('reinitializeCkEditor', () => {
        //     // Destruye la instancia actual de CKEditor
        //     if (document.querySelector('.ck-editor__editable')) {
        //         document.querySelector('.ck-editor__editable').remove();
        //     }

        //     // Vuelve a inicializar CKEditor
        //     ClassicEditor
        //         .create(document.querySelector('#ckeditor'), {
        //             heading: {
        //                 options: [
        //                     { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
        //                     { model: 'heading4', view: 'h4', title: 'Title', class: 'ck-heading_heading4' },
        //                     { model: 'heading5', view: 'h5', title: 'Subtitle', class: 'ck-heading_heading5' }
        //                 ]
        //             },
        //             toolbar: ['undo', 'redo', '|', 'heading', 'bold', 'italic', '|', 'numberedList', 'bulletedList'],
        //         })
        //         .then(function(ckeditor) {
        //             ckeditor.model.document.on('change:data', () => {
        //                 @this.set('problem_statement', ckeditor.getData());
        //             })
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         });
        // });
        // window.livewire.on('reset-ckeditor', msg =>  {
        //     // buscar la manera de resetear el textarea usado por el ck editor porque de esta manera no se puede :(
        //     document.getElementById("ckeditor").value = "";
        // });
    });

</script>


<!-- Alpine Plugins -->
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>