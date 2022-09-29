<div class="card">
    <div class="card-header">
        <h3 class="card-title">Latest Added Tests</h3>
        <div class="card-tools">
            <!-- Maximize Button -->
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
        </div>
    </div>

    <div class="card-body p-0 text-sm">
        <ul class="products-list product-list-in-card pl-2 pr-2">
            @forelse($tests as $test)
                <li class="item px-2">
                    <div class="product-img">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalImages"
                            onclick="changeSrcHref('{{ asset('/storage/'. $test->url) }}', '{{url('admin/pets/'.$pet->id.'/consultations/'.$test->testable_id)}}', '2048px')"
                            title="Show">
                            <img src="{{ url('vendor/adminlte/dist/img/pdf.png') }}"
                                style="width: 48px; height: 48px; object-fit: cover;">
                        </a>
                    </div>
                    <div class="product-info">
                        {{ $test->name }}

                        <span class="float-right">
                            <a href="{{route('admin.pets.consultations.show', ['pet' => $pet, 'consultation' => $test->testable]) }}"
                                class="text-black"
                                target="_blank"
                                rel="noopener noreferrer">
                                    Consultation: {{ str_pad($test->testable_id, 5, "0", STR_PAD_LEFT) }}
                            </a>
                        </span>

                        <span class="product-description">
                            {{ $test->updated_at->diffForHumans() }}
                        </span>
                    </div>
                </li>
            @empty
                <li class="item px-2">
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
                </li>
            @endforelse
        </ul>
    </div>

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
