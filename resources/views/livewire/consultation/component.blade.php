<div wire:init="loadItems">
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">
                        {{ $pageTitle }}: {{ $pet->name != null ? $pet->name : $pet->code }}
                        @if($pet->status == 'Dead')
                            <sup><i class="fas fa-cross"></i></sup>
                        @endif
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">...</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">...</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $pet->user) }}">{{ $pet->user->name }}</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.pets.show', $pet) }}">
                                @if($pet->name) {{ $pet->name }} @else {{ $pet->code }} @endif
                            </a>
                        </li>
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
                    @can('pets_show')
                        <a href="{{ route('admin.pets.show', $pet) }}"
                            class="btn btn-block btn-default mb-3">
                            <i class="far fa-arrow-alt-circle-left"></i>
                            Pet
                        </a>
                    @endcan

                    @can('consultations_update')
                        <a href="javascript:void(0)"
                            wire:click.prevent="loadDobField()"
                            onclick="bindTextareas()"
                            title="Create"
                            class="btn bg-gradient-primary btn-block mb-3">
                                <span wire:loading.remove wire:target="loadDobField">
                                   <i class="fas fa-fw fa-plus"></i>
                                   Add Consultation
                                </span>
                                <span wire:loading wire:target="loadDobField">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i>
                                     Please, wait...
                                </span>
                        </a>
                    @endcan

                    <div class="card card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Filters</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li wire:click="$set('filter', 'All')"
                                    class="nav-item {{ $filter == 'All' ? 'font-weight-bold' : ''}}">
                                    <a href="javascript:void(0)"
                                        class="nav-link">
                                        <i class="fas fa-fw fa-inbox mr-1"></i><span> All</span>
                                        @if($filter == 'All' )
                                            <i class="fas fa-caret-right ml-1"></i>
                                        @endif
                                        <span class="badge bg-primary float-right">{{ $consultations_quantity }}</span>
                                    </a>
                                </li>
                                <li wire:click="$set('filter', 'Trash')"
                                    class="nav-item {{ $filter == 'Trash' ? 'font-weight-bold' : ''}}">
                                    <a href="javascript:void(0)"
                                        class="nav-link">
                                        <i class="far fa-fw fa-trash-alt mr-1"></i><span> Trash</span>
                                         @if($filter == 'Trash' )
                                            <i class="fas fa-caret-right ml-1"></i>
                                        @endif
                                        <span class="badge bg-danger float-right">{{ $deleted_consultations_quantity }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

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
                            @if($this->filter == 'All')
                                <h3 class="card-title">Consultations</h3>
                            @elseif($this->filter == 'Trash')
                                <h3 class="card-title">Trashed consultations</h3>
                            @endif

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
                                <div class="btn btn-default btn-sm checkbox-toggle">
                                    <input type="checkbox"
                                        class=""
                                        id="check8"
                                        wire:model="checkAllConsultations"
                                        wire:click.prevent="updateCheckAllConsultations"
                                        name="check8">
                                    <label for="check8" class="sr-only">Check all</label>
                                </div>

                                <div class="btn-group">
                                    @if($this->filter == 'All')
                                        @can('consultations_destroy')
                                            <!-- Delete Checked button -->
                                            <button type="button" class="btn btn-default btn-sm"
                                                onclick="confirmDeleteConsultations('Are you sure you want delete this consultations?', 'You can recover it from Recycle Bin!', 'Consultations', 'deleteChecked')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    @elseif($this->filter == 'Trash')
                                        @can('consultations_destroy')
                                            <!-- Delete Checked button -->
                                            <button type="button" class="btn btn-default btn-sm"
                                                onclick="confirmDestroyConsultations('Are you sure you want destroy this consultations?', 'This action can not be undone!', 'Consultations', 'destroyChecked')">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        @endcan
                                    @endif

                                    @if($this->filter == 'Trash')
                                        @can('consultations_destroy')
                                             <!-- Delete Checked button -->
                                            <button type="button" class="btn btn-default btn-sm"
                                                onclick="confirmRestoreConsultations('Are you sure you want restore this consultations???', 'This action can be undone!', 'Consultations', 'restoreChecked')">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        @endcan
                                    @endif
                                </div>
                                <!-- /.btn-group -->
                            </div>

                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        @forelse($consultations as $consultation)
                                            <tr id="r{{ $consultation->id }}" class="{{ $this->checkAllConsultations == true ? 'bg-gradient-light disabled' : '' }}">
                                                <td>
                                                    <div class="icheck-primary">
                                                        <input type="checkbox"
                                                            value="{{ $consultation->id }}"
                                                            id="c{{ $consultation->id }}"
                                                            wire:model.defer="checkedConsultations"
                                                            onchange="changeBackground(this.id)"
                                                            {{ $this->checkAllConsultations == true ? 'disabled' : '' }}>
                                                        <label for="check6"></label>
                                                    </div>
                                                </td>
                                                <td class="mailbox-star" title="{{ $consultation->consult_status }}">
                                                    <i class="fas fa-star text-xs {{ $consultation->consult_status == 'Closed' ? 'text-warning' : 'text-muted'}}">
                                                    </i>
                                                </td>
                                                <td class="mailbox-name text-sm" title="{{ $consultation->user->name }}">
                                                    @if( strlen($consultation->user->name) > 18)
                                                        {{ substr($consultation->user->name, 0, 15) }}...
                                                    @else
                                                        {{ $consultation->user->name }}
                                                    @endif
                                                </td>
                                                <td title="{{ $consultation->prognosis }}">
                                                    <span class="fa-stack fa-1x m-0">
                                                        <i class="fas fa-circle fa-stack-2x {{ $consultation->color }}"></i>
                                                        <i class="fas fa-heartbeat fa-stack-1x fa-inverse text-light"></i>
                                                    </span>
                                                </td>
                                                <td class="mailbox-subject">
                                                    <a href="{{ route('admin.pets.consultations.show', ['pet' => $pet, 'consultation' => $consultation]) }}"
                                                        class="{{-- text-warning font-weight-bolder --}}">
                                                        @if($consultation->diagnosis)
                                                            @if( strlen($consultation->diagnosis) > 38)
                                                                {{ substr($consultation->diagnosis, 0, 35) }}...
                                                            @else
                                                                {{ $consultation->diagnosis }}
                                                            @endif
                                                        @else
                                                            Undetermined diagnosis
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="mailbox-attachment text-xs">
                                                    @if($consultation->images()->count())
                                                        <i class="fas fa-images text-muted"></i>
                                                    @endif
                                                    @if($consultation->tests()->count())
                                                        <i class="fas fa-paperclip text-muted"></i>
                                                    @endif
                                                </td>
                                                <td class="mailbox-date">
                                                    <small class="text-xs">{{ $consultation->updated_at->diffForHumans() }}</small>
                                                </td>
                                                <td width="5px">
                                                    <!-- COMMENT: Muestra opciones de editar y eliminar registros activos -->
                                                    @if($this->filter == 'All')
                                                        <div class="btn-group">
{{--                                                             @can('consultations_update')
                                                                <a href="javascript:void(0)"
                                                                    wire:click.prevent="edit({{ $consultation }})"
                                                                    title="Edit"
                                                                    class="btn btn-sm btn-link p-1 border border-0">
                                                                        <i class="fas fa-edit text-muted"></i>
                                                                </a>
                                                            @endcan --}}

                                                            @can('consultations_destroy')
                                                                <a href="javascript:void(0)"
                                                                    onclick="confirm('{{$consultation->id}}', 'Are you sure you want delete this consultation?', 'You can recover it from Recycle Bin!', 'Consultation', 'destroy')"
                                                                    {{-- wire:click.prevent="destroy({{ $consultation }})" --}}
                                                                    title="Delete"
                                                                    class="btn btn-sm btn-link p-1 border border-0">
                                                                        <i class="fas fa-trash text-muted"></i>
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    @endif
                                                    <!-- COMMENT: Muestra opciones de restaurar o destruir los registros de la papelea -->
                                                    @if($this->filter == 'Trash')
                                                        <div class="btn-group">
                                                            @can('consultations_restore')
                                                                <a href="javascript:void(0)"
                                                                    wire:click.prevent="restore({{ $consultation->id }})"
                                                                    title="Restore"
                                                                    class="btn btn-sm btn-link border border-0">
                                                                    <i class="fas fa-history text-muted"></i>
                                                                </a>
                                                            @endcan

                                                            @can('consultations_delete')
                                                                <a href="javascript:void(0)"
                                                                    onclick="confirm('{{$consultation->id}}', 'Are you sure you want delete this consultation?', 'You won\'t be able to revert this!', 'Consultation', 'forceDelete')"
                                                                    title="Destroy"
                                                                    class="btn btn-sm btn-link p-1 border border-0">
                                                                        <i class="fas fa-trash-alt text-danger"></i>
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    @endif
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
                                <!-- /.table -->

                                <!-- COMMENT: Muestra sppiner cuando el componente no está readyToLoad -->
                                <div class="d-flex justify-content-center">
                                    <p wire:loading wire:target="loadItems" class="display-4 text-muted pt-3"><i class="fas fa-fw fa-spinner fa-spin"></i></p>
                                </div>

                            </div>
                            <!-- /.mail-box-messages -->

                            @if(count($consultations) > 10)
                                <div class="mailbox-controls">
                                    <!-- Check all button -->
                                    <div class="btn btn-default btn-sm checkbox-toggle">
                                        <input type="checkbox"
                                            class=""
                                            id="check9"
                                            wire:model="checkAllConsultations"
                                            wire:click.prevent="updateCheckAllConsultations"
                                            name="check9">
                                        <label for="check9" class="sr-only">Check all</label>
                                    </div>

                                    <div class="btn-group">
                                        @if($this->filter == 'All')
                                            @can('consultations_destroy')
                                                <!-- Delete Checked button -->
                                                <button type="button" class="btn btn-default btn-sm"
                                                    onclick="confirmDeleteConsultations('Are you sure you want delete this consultations?', 'You can recover it from Recycle Bin!', 'Consultations', 'deleteChecked')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endcan
                                        @elseif($this->filter == 'Trash')
                                            @can('consultations_destroy')
                                                <!-- Delete Checked button -->
                                                <button type="button" class="btn btn-default btn-sm"
                                                    onclick="confirmDestroyConsultations('Are you sure you want destroy this consultations?', 'This action can not be undone!', 'Consultations', 'destroyChecked')">
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </button>
                                            @endcan
                                        @endif

                                        @if($this->filter == 'Trash')
                                            @can('consultations_destroy')
                                                 <!-- Delete Checked button -->
                                                <button type="button" class="btn btn-default btn-sm"
                                                    onclick="confirmRestoreConsultations('Are you sure you want restore this consultations???', 'This action can be undone!', 'Consultations', 'restoreChecked')">
                                                    <i class="fas fa-history"></i>
                                                </button>
                                            @endcan
                                        @endif
                                    </div>
                                    <!-- /.btn-group -->
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->


                        <div class="card-footer p-0">

                            <div class="mailbox-controls">
                                <!-- Check all button -->
{{--                                 <button type="button" class="btn btn-default btn-sm checkbox-toggle">
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
                                </div> --}}
                                <!-- /.btn-group -->

{{--                                 <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </button> --}}

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
                        <div wire:loading.class="overlay dark" wire:target="store, update, destroy, delete, restore">
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


{{--  <script>
    ClassicEditor
        .create(document.querySelector('#treatment_plan'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('treatment_plan', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>
 --}}

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


    // window.addEventListener('swal:deleteConsultations', event => {
    //     Swal.fire({
    //         title:event.detail.title,
    //         html:event.detail.html,
    //         type: 'warning',
    //         showCloseButton:true,
    //         showCancelButton:true,
    //         cancelButtonText:'No',
    //         cancelButtonColor:'#d33',
    //         confirmButtonText:'Yes',
    //         confirmButtonColor:'#3085d6',
    //         allowOutsideClick: false,
    //     }).then(function(result){
    //         if(result.value){
    //             window.livewire.emit('deleteChecked', event.detail.checkIDs);
    //             Swal.fire(
    //                 'Deleted!',
    //                 'Consultations has been deleted.',
    //                 'success'
    //             )
    //         }
    //     });
    // });

        {{-- Funtion to confirm the deletion of items --}}
    function confirmDeleteConsultations(title, text, model, event) {
        Swal.fire({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.livewire.emit(event),
                Swal.fire(
                    'Deleted!',
                     model + ' has been deleted.',
                    'success'
                )
            }
        })
    }

    {{-- Funtion to confirm the deletion of items --}}
    function confirmDestroyConsultations(title, text, model, event) {
        Swal.fire({
            title: title,
            text: text,
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.livewire.emit(event),
                Swal.fire(
                    'Destroyed!',
                     model + ' has been deleted.',
                    'success'
                )
            }
        })
    }

    {{-- Funtion to confirm restore --}}
    function confirmRestoreConsultations(title, text, model, event) {
        Swal.fire({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.value) {
                window.livewire.emit(event),
                Swal.fire(
                    'Restored!',
                     model + ' has been restored.',
                    'success'
                )
            }
        })
    }

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


    // Función para agregar/quitar un backgroung al seleccionar un checkbox
    function changeBackground(id) {

        var partial_id = document.getElementById(id).value;
        var row = document.getElementById("r"+partial_id);

        row.classList.toggle("bg-gradient-light");
        row.classList.toggle("disabled");
        // if(id != undefined){

        // }

        // if(id == undefined){
        //     window.alert("undefined");
        //     var x = document.getElementsByTagName("tr");
        //     var i;
        //     for (i = 0; i < x.length; i++) {
        //         x[i].classList.toggle("bg-gradient-light");
        //         x[i].classList.toggle("disabled");
        //     }
        // }
    }

    function bindTextareas() {
        document.getElementById('textareaProblemStatement').value = document.getElementById('ckeditor').value
    }

</script>


<!-- Alpine Plugins -->
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>