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
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $pet->user) }}">...</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pets.show', $pet)}}">{{ $pet->name }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pets.consultations', $pet)}}">Consultations</a></li>
                        <li class="breadcrumb-item active">{{ $pageTitle }} #{{ $consultation->id }}</li>
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
                    <a href="{{ route('admin.pets.consultations', $pet) }}"
                        class="btn btn-block btn-default mb-3">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        Consultations
                    </a>

                    <!-- Button trigger modal -->
                    <button type="button"
                        class="btn bg-gradient-primary btn-block mb-3"
                        data-toggle="modal"
                        data-target="#modalForm">
                       <i class="fas fa-fw fa-plus"></i> Add Consultation
                    </button>

                    <div class="card card-primary card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Folders</h3>

                            <div class="card-tools">
                                <button type="button"
                                    class="btn btn-tool"
                                    data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
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
                                    {{ $pet->neuteredOrSpayed }}

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
                            <h3 class="card-title">Consultation details</h3>

                            <div class="card-tools">
                                <span class="text-muted text-sm" wire:loading >Please, wait... <i class="fas fa-fw fa-spinner fa-spin"></i></span>
                                <a href="javascript:void(0)" wire:click="previusConsultation({{$consultation->id}})" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                                <a href="javascript:void(0)" wire:click="nextConsultation({{$consultation->id}})" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body p-0">
                            <!-- /.mailbox-read-info -->
                            <div class="mailbox-controls with-border text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>
                                <!-- /.btn-group -->

                                <button type="button" class="btn btn-default btn-sm" title="Print">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                            <!-- /.mailbox-controls -->

                            <div class="mailbox-read-info">
                                <h4>
                                    {{ $consultation->user->name }} DVM
                                    @if($consultation->consult_status != 'Closed')
                                        <span class="text-xs badge badge-primary float-right">
                                            {{ $consultation->consult_status }}
                                        </span>
                                    @endif
                                </h4>
                                <span>
                                    Consultation ID: #{{ $consultation->id }}
                                    <span class="mailbox-read-time float-right">
                                        {{ $consultation->created_at->format('d-M-Y h:i A') }}
                                    </span>
                                </span>
                            </div>

                            <div class="mailbox-read-message font-weight-light">
                                <h4>Pet information</h4>
                                <div class="row">
                                    <div class="col-md-6"><b>Pet: </b>{{ $consultation->pet->name }}</div>
                                    <div class="col-md-6"><b>Age: </b>{{ $consultation->age }}</div>
                                </div>
                                <hr>

                                <h4>Vital statistics</h4>
                                <div class="row">
                                    <div class="col-md"><b>Weight: </b>{{ $consultation->weight }} kilograms.</div>
                                    <div class="col-md"><b>Temperature: </b>{{ $consultation->temperature }} °C</div>
                                </div>
                                <div class="row">
                                    <div class="col-md"><b>Capillary refill time: </b>{{ $consultation->capillary_refill_time }}</div>
                                    <div class="col-md"><b>Heart rate: </b>{{ $consultation->heart_rate }} beats per minute</div>
                                </div>
                                <div class="row">
                                    <div class="col-md"><b>Pulse: </b>{{ $consultation->pulse }}</div>
                                    <div class="col-md"><b>Respiratory rate: </b>{{ $consultation->respiratory_rate }} breaths per minute</div>
                                </div>
                                <hr>

                                <h4>Other</h4>
                                <div class="row">
                                    <div class="col-md"><b>Reproductive status: </b>{{ $consultation->reproductive_status }}</div>
                                    <div class="col-md"><b>Consciouness: </b>{{ $consultation->consciousness }}</u></div>
                                </div>
                                <div class="row">
                                    <div class="col-md"><b>Hydration: </b>{{ $consultation->hydration }}</div>
                                    <div class="col-md"><b>Pain: </b>{{ $consultation->pain }}</div>
                                </div>
                                <div class="row">
                                <div class="col-md"><b>Body condition: </b>{{ $consultation->body_condition }}</div>
                                {{--   <div class="col-md"><b>Consultation diagnosis:</b> <u>{{ $consultation->diagnosis }}</u></div>
                                  <div class="col-md"><b>Prognosis:</b> <u>{{ $consultation->prognosis }}</u></div>
                                  <div class="col-md"><b>Treatment plan:</b> <u>{{ $consultation->treatment_plan }}</u></div> --}}
                                </div>
                                <hr>

                                {!! $consultation->problem_statement !!}
                                <hr>

                                <div class="row lead">
                                    <div class="col-md-6">
                                        <h4>
                                            Diagnosis:
                                            <span class="badge badge-warning">
                                                {{ $consultation->diagnosis }}
                                            </span>
                                        </h4>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>
                                            Prognosis:
                                            <span class="badge badge-warning">
                                                {{ $consultation->prognosis }}
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                                <hr>

                                <h4>Treatment plan</h4>
                                {{ $consultation->treatment_plan }}
                                <hr>
                            <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-white">
                          <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                            <li>
                              <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                              <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Sep2014-report.pdf</a>
                                    <span class="mailbox-attachment-size clearfix mt-1">
                                      <span>1,245 KB</span>
                                      <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                    </span>
                              </div>
                            </li>
                            <li>
                              <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>

                              <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> App Description.docx</a>
                                    <span class="mailbox-attachment-size clearfix mt-1">
                                      <span>1,245 KB</span>
                                      <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                    </span>
                              </div>
                            </li>
{{--                             <li>
                              <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

                              <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> photo1.png</a>
                                    <span class="mailbox-attachment-size clearfix mt-1">
                                      <span>2.67 MB</span>
                                      <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                    </span>
                              </div>
                            </li>
                            <li>
                              <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

                              <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> photo2.png</a>
                                    <span class="mailbox-attachment-size clearfix mt-1">
                                      <span>1.9 MB</span>
                                      <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                    </span>
                              </div>
                            </li> --}}
                          </ul>
                        </div>
                        <!-- /.card-footer -->
                        <div class="card-footer">
                          <div class="float-right">
                            <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                            <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
                          </div>
                          <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                          <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->


            </div>
        </div><!-- /.container-fluid -->
    </section>
    {{-- @include('livewire.consultation.form') --}}
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

