<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Latest Added Pictures
        </h3>
        <div class="card-tools">
            <!-- Maximize Button -->
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
        </div>
    <!-- /.card-tools -->

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row ">
            @forelse($images as $image)
                <div class="col-sm-12 col-md-4 col-lg-3 text-center">
                    <div class="border border-1 rounded-top mb-1 overflow-hidden">
                        <!-- Button trigger modal -->
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalImages"
                            onclick="changeSrcHref('{{ asset('/storage/'.$image->url) }}', '{{url('admin/pets/'.$pet->id.'/consultations/'.$image->imageable_id)}}')"
                            title="View">
                            <img src="{{ asset('/storage/'. $image->url) }}"
                                class="img-fluid"
                                style="width: 100%; height: 120px; object-fit: cover;" alt="Image">
                        </a>
                    </div>

                    <div class="mb-3 border border-1 rounded-bottom overflow-hidden">
                        <p class="text-xs m-1" title="{{ $image->name }}">
                            @if( strlen($image->name) > 27)
                                {{ substr($image->name, 0, 24) }}...
                            @else
                                {{ $image->name }}
                            @endif
                        </p>
                        <a href="{{route('admin.pets.consultations.show', ['pet' => $pet, 'consultation' => $image->imageable]) }}"
                            class="btn btn-block btn-default btn-xs btn-flat border border-0"
                            target="_blank"
                            rel="noopener noreferrer">
                            Consultation {{ $image->imageable_id }}
                            <i class="fas fa-fw fa-external-link-alt"></i>
                        </a>
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
    </div>
    <!-- /.card-body -->

    <div class="card-footer d-flex justify-content-center">
        <div wire:loading wire:target="loadMore">
            <span class="loader"></span>
        </div>

        <button wire:click="loadMore"
            wire:loading.remove
            class="btn bg-gradient-lime my-2 {{ $this->load >= $this->testsQuantity ? 'd-none':'' }}">
                Load more
        </button>
    </div>
</div>
<!-- /.card -->
