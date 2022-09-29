<div wire:init="loadItems">
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">
                        {{ $pet->name != null ? $pet->name : $pet->code }} / {{ $pageTitle }}
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
                <!-- Link pet -->
                <div class="col-md-3">
                    <a href="{{ route('admin.pets.show', $pet) }}"
                        class="btn btn-block btn-default mb-3
                        @cannot('pets_show') disabled @endcannot">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        Pet
                    </a>

                    <!-- Create cponsultation -->
                    <a href="javascript:void(0)"
                        wire:click.prevent="loadDobField()"
                        onclick="bindTextareas()"
                        title="Add new consultation"
                        class="btn bg-gradient-primary btn-block mb-3
                        @cannot('consultations_store') disabled @endcannot"
                        wire:loading.class="disabled">
                            <span wire:loading.remove wire:target="loadDobField">
                               <i class="fas fa-fw fa-plus-circle"></i>
                               Add Consultation
                            </span>
                            <span wire:loading wire:target="loadDobField">
                                <i class="fas fa-fw fa-spinner fa-spin"></i>
                                 Please, wait...
                            </span>
                    </a>

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
                                <div class="form-row my-2">

                                    <div class="col-sm-6">
                                        @include('common.select')
                                    </div>

                                    <div class="col-sm-6">
                                        @include('common.search')
                                    </div>
                                </div>
                                <!-- /.Datatable filters -->
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body p-0">
                            <!-- Control buttons -->
                            <div class="mailbox-controls">
                                <!-- Check all button -->
                                    <div class="btn checkbox-toggle icheck-pomegranate ml-2">
                                        <input type="checkbox"
                                        id="checkAll"
                                        wire:model="select_page"
                                        {{ !count($consultations) ? 'disabled' : '' }}>
                                        <label class="sr-only" for="checkAll">Click to check all items</label>
                                    </div>
                                <div class="btn-group">
                                    @if($this->filter == 'All')
                                        <!-- Destroy hecked consultations button -->
                                        @can('consultations_delete')
                                            <button type="button" class="btn btn-default btn-sm"
                                                wire:click.prevent="deleteMultiple">
                                                <!-- All but small screen -->
                                                <span class="d-none d-sm-block">
                                                    <i class="fas fa-fw fa-trash"></i>
                                                    Delete [<span id="contador">{{ count($this->selected) }}</span>]
                                                </span>
                                                <!-- Only small screen-->
                                                <span class="d-block d-sm-none">
                                                    <i class="fas fa-fw fa-trash"></i>[<span id="contador">{{ count($this->selected) }}</span>]
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
                                                    <i class="fas fa-fw fa-trash text-danger"></i>
                                                    Destroy [<span id="contador">{{ count($this->selected) }}</span>]
                                                </span>
                                                <span class="d-block d-sm-none">
                                                    <i class="fas fa-fw fa-trash text-danger"></i>
                                                        [<span id="contador">{{ count($this->selected) }}</span>]
                                                </span>
                                            </button>
                                        @endcan
                                    @endif

                                    @if($this->filter == 'Trash')
                                        <!-- Restore hecked consultations button -->
                                        @can('consultations_restore')
                                            <button type="button" class="btn btn-default btn-sm"
                                                wire:click="restoreMultiple">
                                                <span class="d-none d-sm-block">
                                                    <i class="fas fa-fw fa-history"></i>
                                                    Restore [<span id="contador2">{{ count($this->selected) }}</span>]
                                                </span>
                                                <span class="d-block d-sm-none">
                                                    <i class="fas fa-fw fa-history"></i>
                                                    [<span id="contador2">{{ count($this->selected) }}</span>]
                                                </span>
                                            </button>
                                        @endcan
                                    @endif
                                </div>
                                <!-- /.btn-group -->

                                <div class="float-right">
                                    <!-- Botones para pantallas superior a sm -->
                                    <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
                                        <label class="btn {{ $this->filter == 'All' ? 'bg-gradient-primary active' : 'bg-gradient-gray' }}">
                                            <input type="radio" name="options" id="option_b1" autocomplete="off"  wire:click="$set('filter', 'All')">
                                            <i class="fas fa-fw fa-inbox"></i> <span class="font-weight-normal">Active</span>
                                            <span class="ml-1 badge bg-success float-right">
                                                {{ $consultations_quantity }}
                                            </span>
                                        </label>
                                        <label class="btn {{ $this->filter == 'Trash' ? 'bg-gradient-primary active' : 'bg-gradient-gray' }}">
                                            <input type="radio" name="options" id="option_b2" autocomplete="off"  wire:click="$set('filter', 'Trash')">
                                            <i class="fas fa-fw fa-recycle"></i> <span class="font-weight-normal">Recycle</span>
                                            <span class="ml-1 badge bg-danger float-right">
                                                {{ $deleted_consultations_quantity }}
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <!-- /.btn-group -->
                            </div>

                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover {{-- table-striped --}}">
                                    <tbody>
                                        @forelse($consultations as $consultation)
                                            <tr  id="rowcheck{{ $consultation->id }}" class="{{ $this->select_page ? 'table-active font-weight-bold' : ''}}">
                                                <td>
                                                    <div class="icheck-pomegranate">
                                                        <input type="checkbox"
                                                        id="check{{$consultation->id}}"
                                                        wire:model.defer="selected"
                                                        value="{{$consultation->id}}"
                                                        onchange="updateInterface(this.id)"
                                                        class="counter">
                                                        <label class="sr-only" for="check{{$consultation->id}}">Click to check</label>
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
                                                <td width="5px">
                                                    <!-- Edit and delete consultations -->
                                                    @if($this->filter == 'All')
                                                        <div class="btn-group">
                                                            @can('consultations_delete')
                                                                <a href="javascript:void(0)"
                                                                    wire:click.prevent="delete({{ $consultation }})"
                                                                    title="Delete"
                                                                    class="btn btn-sm btn-link p-1 border border-0">
                                                                        <i class="fas fa-trash text-muted"></i>
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    @endif
                                                    <!-- Edit and destroy consultations -->
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
                                                            @can('consultations_destroy')
                                                                <a href="javascript:void(0)"
                                                                    onclick="confirm('{{$consultation->id}}', 'Are you sure you want delete this consultation?', 'You won\'t be able to revert this!', 'Consultation', 'destroy')"
                                                                    title="Destroy"
                                                                    class="btn btn-sm btn-link p-1 border border-0">
                                                                        <i class="fas fa-trash text-danger"></i>
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

    window.addEventListener('destroyed', event => {
        notify(event)
    });

    window.addEventListener('restored', event => {
        notify(event)
    });

    window.addEventListener('deleted-error', event => {
        notify(event)
    });

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


    function bindTextareas() {
        document.getElementById('textareaProblemStatement').value = document.getElementById('ckeditor').value
    }

    function updateInterface(id) {
        uncheckAll();
        trActive(id);
        count(id);
    }

    function uncheckAll() {
        // Desmarca check all si estaba seleccionado al hacer clic en una row
        if (document.getElementById('checkAll').checked) {
            document.getElementById('checkAll').checked = false
        }
    }

    function count() {
        // Selecciona todos los input de tipo chechbox que tengan la clase counter y los cuenta
        document.getElementById("contador").innerHTML = document.querySelectorAll('input[type="checkbox"]:checked.counter').length
        document.getElementById("contador2").innerHTML = document.querySelectorAll('input[type="checkbox"]:checked.counter').length

    }

    function trActive(id) {
        // marca los TR como activados al hacer clic en una row
        var row = document.getElementById("rowcheck"+document.getElementById(id).value)
        row.classList.toggle("table-active")
        row.classList.toggle("font-weight-bold")
    }

</script>

<!-- Alpine Plugins -->
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>