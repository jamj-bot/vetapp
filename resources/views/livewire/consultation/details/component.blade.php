<div wire:init = "loadItems()">
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">
                        {{ $pageTitle }} #{{ $consultation->id }}: {{ $pet->name != null ? $pet->name : $pet->code }}
                        @if($pet->status == 'Dead')
                            <sup><i class="fas fa-cross"></i></sup>
                        @endif
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">...</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">...</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $pet->user) }}">...</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.pets.show', $pet)}}">
                                @if($pet->name) {{ $pet->name }} @else {{ $pet->code }} @endif
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.pets.consultations', $pet) }}">Consultations</a>
                        </li>
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
                    @can('consultations_index')
                        <a href="{{ route('admin.pets.consultations', $pet) }}"
                            class="btn btn-block btn-default mb-3">
                            <i class="far fa-arrow-alt-circle-left"></i>
                            Consultations
                        </a>
                    @endcan

                    @can('consultations_update')
                        <!-- Button trigger modal -->
                        <a href="javascript:void(0)"
                            wire:click.prevent="edit({{ $consultation }})"
                            onclick="bindTextareas()"
                            title="Edit"
                            class="btn bg-gradient-warning btn-block mb-3">

                                <span wire:loading.remove wire:target="edit">
                                   <i class="fas fa-fw fa-edit"></i>
                                   Edit Consultation
                                </span>
                                <span wire:loading wire:target="edit">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i>
                                     Please, wait...
                                </span>
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
                            <h3 class="card-title">Consultation details</h3>

                            <div class="card-tools">
                                <span class="text-muted text-sm" wire:loading >
                                    Please, wait... <i class="fas fa-fw fa-spinner fa-spin"></i>
                                </span>
                                <a href="javascript:void(0)"
                                    wire:click="previusConsultation({{$consultation->id}})"
                                    class="btn btn-tool" title="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="javascript:void(0)"
                                    wire:click="nextConsultation({{$consultation->id}})"
                                    class="btn btn-tool" title="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body p-0">

                            <div class="mailbox-read-info">
                                <h4>
                                    {{ $consultation->user->name }}, DVM
                                    <span class="text-sm float-right">
                                        {{ $consultation->consult_status }}
                                        <i class="fas fa-fw {{ $consultation->consult_status != 'Closed' ? 'fa-info text-info' : 'fa-check-double text-success'}}"></i>
                                    </span>
                                </h4>
                                <span>
                                    Consultation ID: #{{ $consultation->id }}
                                    <span class="mailbox-read-time float-right">
                                        {{ $consultation->created_at->format('d-M-Y h:i A') }}
                                    </span>
                                </span>
                            </div>
                            <!-- /.mailbox-read-info -->

{{--                             <div class="mailbox-controls with-border text-center">
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

                                <a href="{{ route('admin.pets.consultations.export', ['pet' => $pet, 'consultation' => $consultation]) }}"
                                    class="btn btn-default btn-sm"
                                    target="_blank"
                                    rel="noopener"
                                    title="Print">
                                    <i class="far fa-fw fa-file-pdf"></i>
                                </a>
                            </div> --}}
                            <!-- /.mailbox-controls -->

                            <div class="mailbox-read-message font-weight-light">
                                <h4>Pet information</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        {{-- <i class="fas fa-fw fa-horse-head mr-1" style="color: "> --}}
                                        <b></i>Pet name: </b>{{ $consultation->pet->name }}
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <i class="far fa-fw fa-calendar-alt mr-1" style="color: "></i> --}}
                                        <b>Age: </b>{{ $consultation->age }}
                                    </div>
                                </div>

                                <hr>

                                <h4>Vital statistics</h4>
                                <div class="row">
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-weight mr-1" style="color: "></i> --}}
                                        <b>Weight: </b>{{ $consultation->weight }} kilograms.
                                    </div>
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-thermometer-empty mr-1" style="color: "></i> --}}
                                        <b>Temperature: </b>{{ $consultation->temperature }} °C
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-stopwatch mr-1" style="color: "></i> --}}
                                        <b>Capillary refill time: </b>{{ $consultation->capillary_refill_time }}
                                    </div>
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-heartbeat mr-1" style="color: red;"></i> --}}
                                        <b>Heart rate: </b>{{ $consultation->heart_rate }} beats per minute
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-heart mr-1" style="color: tomato;"></i> --}}
                                        <b>Pulse: </b>{{ $consultation->pulse }}
                                    </div>
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-lungs mr-1" style="color: "></i> --}}
                                        <b>Respiratory rate: </b>{{ $consultation->respiratory_rate }} breaths per minute
                                    </div>
                                </div>
                                <hr>

                                <h4>Ancillary info</h4>
                                <div class="row">
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-thermometer mr-1" style="color: "></i> --}}
                                        <b>Reproductive status: </b>{{ $consultation->reproductive_status }}
                                    </div>
                                    <div class="col-md">
                                        <b>Consciouness: </b>{{ $consultation->consciousness }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-tint mr-1" style="color: "></i> --}}
                                        <b>Hydration: </b>{{ $consultation->hydration }}
                                    </div>
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-frown-open mr-1" style="color: #ffc51a"></i> --}}
                                        <b>Pain: </b>{{ $consultation->pain }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        {{-- <i class="fas fa-fw fa-bone mr-1" style="color: "></i> --}}
                                        <b>Body condition: </b>{{ $consultation->body_condition }}
                                    </div>
                                </div>
                                <hr>
                                {!! $consultation->problem_statement !!}
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Diagnosis</h4>


                                        @if($consultation->diagnosis)
                                            <span class="fa-stack fa-2x fa-pull-left">
                                                <i class="fas fa-square fa-stack-2x text-info"></i>
                                                <i class="fas fa-comment-medical fa-stack-1x fa-inverse text-light"></i>
                                            </span>
                                            {{ $consultation->diagnosis }}
                                        @else
                                            <span class="fa-stack fa-2x fa-pull-left">
                                                <i class="fas fa-square fa-stack-2x text-info"></i>
                                                <i class="fas fa-question fa-stack-1x fa-inverse text-light"></i>
                                            </span>
                                            Undetermined
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <h4>Prognosis</h4>
                                        <span class="fa-stack fa-2x fa-pull-left">
                                            <i class="fas fa-square fa-stack-2x {{ $consultation->color }}"></i>
                                            <i class="fas fa-heartbeat fa-stack-1x fa-inverse text-light"></i>
                                        </span>
                                        {{ $consultation->prognosis }}

                                    </div>
                                </div>
                                <hr>

                                <h4>Treatment plan</h4>
                                {{ $consultation->treatment_plan }}
                                <hr>
                            <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.card-body -->


                        <div class="card-footer bg-white" x-data="{ expanded: false }">

                            <button @click="expanded = ! expanded" class="btn btn-light btn-sm btn-block">
                                <i class="fas fa-fw fa-paperclip"></i>Attachments
                            </button>
                            <div x-show="expanded" x-collapse.duration.2000ms>
                                <!--Tab pane with alpine persist-->
                                <div x-data="{ tab: $persist(0) }">
                                    <nav class="mt-2">
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a x-on:click="tab = 0"
                                                class="nav-link"
                                                :class="tab == 0 ? 'active' : ''"
                                                id="nav-images-tab"
                                                data-toggle="tab"
                                                href="#nav-images"
                                                role="tab"
                                                aria-controls="nav-images"
                                                aria-selected="true">Images
                                            </a>
                                            <a x-on:click="tab = 1"
                                                class="nav-link"
                                                :class="tab == 1 ? 'active' : ''"
                                                id="nav-tests-tab"
                                                data-toggle="tab"
                                                href="#nav-tests"
                                                role="tab"
                                                aria-controls="nav-tests"
                                                aria-selected="false">Tests
                                            </a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade" :class="tab == 0 ? 'show active' : ''" id="nav-images" role="tabpanel" aria-labelledby="nav-images-tab">
                                            <h4 class="lead mt-2">Medical images</h4>

                                            @can('consultations_index')
                                                <div class="mailbox-attachments row">
                                                    @forelse($consultation->images as $image)
                                                        <div class="col-sm-12 col-md-4 col-lg-3 text-center">
                                                            <div class="border border-1 rounded-top mb-1 overflow-hidden">
                                                                <!-- Button trigger modal -->
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#modalImages"
                                                                    onclick="changeSrcHref('{{ asset('/storage/'. $image->url) }}', '{{url('admin/pets/'.$pet->id.'/consultations/'.$consultation->id)}}')"
                                                                    title="View">
                                                                    <img src="{{ asset('/storage/'. $image->url) }}"
                                                                        class="img-fluid"
                                                                        style="width: 100%; height: 100px; object-fit: cover;" alt="Image">
                                                                </a>
                                                            </div>

                                                            <div class="mb-3 border border-1 rounded-bottom overflow-hidden">
                                                                <p class="text-xs m-1">
                                                                    {{ $image->name }}
                                                                </p>
                                                                <div class="btn-group btn-block">
                                                                    @can('consultations_download_files')
                                                                          <button wire:click.prevent="downloadImage({{ $image }})"
                                                                            class="btn btn-default btn-flat btn-xs border border-0" title="Download image">
                                                                            <i class="fas fa-fw fa-cloud-download-alt"></i>
                                                                        </button>
                                                                        @endcan
                                                                        @can('consultations_delete_files')
                                                                        <button wire:click.prevent="deleteImage({{ $image }})"
                                                                            class="btn btn-default btn-flat btn-xs border border-0" title="Delete image">
                                                                            <i class="fas fa-fw fa-trash-alt"></i>
                                                                        </button>
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="container">
                                                            <div class="row text-center text-muted pt-3">
                                                                <div class="col-12">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="76" height="76" fill="currentColor" class="bi bi-images" viewBox="0 0 16 16">
                                                                      <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                                                      <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"/>
                                                                    </svg>
                                                                </div>
                                                                <div class="col-12">
                                                                    <p class="text-lg lead">
                                                                         No attached images
                                                                    </p>
                                                                </div>
                                                             </div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            @endcan

                                            @can('consultations_save_files')
                                                <!-- Upload images form -->
                                                <div class="my-3"
                                                    x-data="{ isUploading: false, progress: 0 }"
                                                    x-on:livewire-upload-start="isUploading = true"
                                                    x-on:livewire-upload-finish="isUploading = false"
                                                    x-on:livewire-upload-error="isUploading = false"
                                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                                    <!-- File Input -->
                                                    <form wire:submit.prevent="saveImages">
                                                        <div class="input-group mb-3">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="inputField"  wire:model="images" accept="image/x-png,image/gif,image/jpeg" multiple>
                                                                <label class="custom-file-label" for="inputField" aria-describedby="inputGroupFileAddon">Choose file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="submit" class="input-group-text btn btn-sm bg-gradient-primary" id="inputGroupFileAddon">Upload</button>
                                                            </div>
                                                        </div>

                                                        <small class="text-danger">
                                                            @error('images.*') <span class="error">{{ $message }}</span> @enderror
                                                        </small>
                                                    </form>

                                                    <!-- Progress Bar -->
                                                    <div x-show="isUploading">
                                                        <progress max="100" x-bind:value="progress"></progress>
                                                    </div>
                                                </div>
                                            @endcan

                                            @if($images)
                                                <div class="mailbox-attachment-info p-2 mb-3 border border-1">
                                                    <h5 class="lead">Preview</h5>
                                                    {{-- <a href=""></a> --}}
                                                    @foreach($images as $image)
                                                        <img src="{{ $image->temporaryUrl() }}"
                                                            style="width: 90px; height: 55px; object-fit: cover;"
                                                            class="img-fluid img-thumbnail bg-transparent rounded-lg mb-2">
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="tab-pane fade" :class="tab == 1 ? 'show active' : ''" id="nav-tests" role="tabpanel" aria-labelledby="nav-tests-tab">
                                            <h4 class="lead mt-2">Lab tests</h4>

                                            @can('consultations_index')
                                                <div class="row">
                                                    @forelse($consultation->tests as $test)
                                                        <div class="col-sm-12 col-md-4 col-lg-3 text-center">

                                                            <div class="border border-1 rounded-top mb-1 p-1 overflow-hidden bg-gradient-dark">
                                                                <!-- Button trigger modal -->
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#modalImages"
                                                                    onclick="changeSrcHref('{{ asset('/storage/'. $test->url) }}', '{{url('admin/pets/'.$pet->id.'/consultations/'.$consultation->id)}}', '2048px')"
                                                                    title="View">
                                                                    <img src="{{ url('vendor/adminlte/dist/img/pdf.png') }}"
                                                                        style="width: 64px; height: 64px; object-fit: cover;">
                                                                </a>
                                                            </div>

                                                            <div class="mb-3 border border-1 rounded-bottom overflow-hidden">
                                                                <p class="text-xs m-1">
                                                                    {{ $test->name }}
                                                                </p>
                                                                <div class="btn-group btn-block">
                                                                    @can('consultations_download_files')
                                                                          <button wire:click.prevent="downloadTest({{ $test }})"
                                                                            class="btn btn-default btn-flat btn-xs border border-0" title="Download Test">
                                                                            <i class="fas fa-fw fa-cloud-download-alt"></i>
                                                                        </button>
                                                                        @endcan
                                                                        @can('consultations_delete_files')
                                                                        <button wire:click.prevent="deleteTest({{ $test }})"
                                                                            class="btn btn-default btn-flat btn-xs border border-0" title="Delete Test">
                                                                            <i class="fas fa-fw fa-trash-alt"></i>
                                                                        </button>
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="container">
                                                            <div class="row text-center text-muted pt-3">
                                                                <div class="col-12">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="76" height="76" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                                                                    </svg>
                                                                </div>
                                                                <div class="col-12">
                                                                    <p class="text-lg lead">
                                                                         No attached documents
                                                                    </p>
                                                                </div>
                                                             </div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            @endcan

                                            @can('consultations_save_files')
                                                <!-- Upload files form -->
                                                <div class="my-3"
                                                    x-data="{ isUploading: false, progress: 0 }"
                                                    x-on:livewire-upload-start="isUploading = true"
                                                    x-on:livewire-upload-finish="isUploading = false"
                                                    x-on:livewire-upload-error="isUploading = false"
                                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                >

                                                    <!-- File Input -->
                                                    <form wire:submit.prevent="saveTests">

                                                        <div class="input-group mb-3">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="inputTestsField"  wire:model="tests" accept="application/pdf" multiple>
                                                                <label class="custom-file-label" for="inputTestsField" aria-describedby="inputGroupTestsAddon">Choose file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="submit" class="input-group-text btn btn-sm bg-gradient-primary" id="inputGroupTestsAddon">Upload</button>
                                                            </div>
                                                        </div>

                                                        <small class="text-danger">
                                                            @error('tests.*') <span class="error">{{ $message }}</span> @enderror
                                                        </small>
                                                    </form>

                                                    <!-- Progress Bar -->
                                                    <div x-show="isUploading">
                                                        <progress max="100" x-bind:value="progress"></progress>
                                                    </div>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-footer -->
                        <div class="card-footer">
                            <div class="float-right">
                                <span class="text-muted text-sm" wire:loading >
                                    Please, wait... <i class="fas fa-fw fa-spinner fa-spin"></i>
                                </span>
                                <a href="javascript:void(0)"
                                    wire:click="previusConsultation({{$consultation->id}})"
                                    class="btn btn-default"
                                    title="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="javascript:void(0)"
                                    wire:click="nextConsultation({{$consultation->id}})"
                                    class="btn btn-default" title="Next">
                                        <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>

                            @can('consultations_destroy')
                                <a href="javascript:void(0)"
                                    wire:click.prevent="destroy({{ $consultation }})"
                                    title="Delete"
                                    class="btn btn-default">
                                        <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            @endcan
                            @can('consultations_export')
                                <a href="{{ route('admin.pets.consultations.export', ['pet' => $pet, 'consultation' => $consultation]) }}"
                                    class="btn btn-default"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    title="Export to PDF">
                                    <i class="far fa-fw fa-file-pdf"></i> Export
                                </a>
                            @endcan
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('livewire.consultation.form')
    @include('common.modal-image')
</div>


<script>
    window.addEventListener('updated', event => {
        notify(event)
    });

    window.addEventListener('deleted', event => {
        notify(event)
    });

    window.addEventListener('uploaded', event => {
        notify(event)
    });

    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg =>  {
            $('#modalForm').modal('show')
        });

        window.livewire.on('hide-modal', msg =>  {
            $('#modalForm').modal('hide')
        });

        window.livewire.on('clear-input-field', msg =>  {
            $("#inputField").val('')
        });
        // window.livewire.on('reset-ckeditor', msg =>  {
        //     // buscar la manera de resetear el textarea usado por el ck editor porque de esta manera no se puede :(
        //     document.getElementById("ckeditor").value = "";
        // });
    });
</script>

<!-- Alpine Plugins -->
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>

<!-- CKEDITOR CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

<!-- CKEDITOR PERONALIZATION -->
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

<script type="text/javascript">
    function changeSrcHref(source, link, height = null) {
        document.getElementById('myObject').data=source
        document.getElementById('myAnchor').href=link

        if (height) {
            document.getElementById('myObject').height = height
        } else {
            document.getElementById('myObject').height = ''
        }
    }

    function bindTextareas() {
        document.getElementById('textareaProblemStatement').value = document.getElementById('ckeditor').value
    }
</script>
