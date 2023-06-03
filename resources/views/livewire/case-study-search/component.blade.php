

<div>
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

<form autocomplete="off" wire:submit.prevent="submit">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Specie (s):</label>
                        <div wire:ignore>
                            <select id="select-species" name="" multiple placeholder="Pick some species" autocomplete="off">
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="inputMinAge" class="form-label">Min age *</label>
                        <input wire:model.lazy="min_age"
                            type="number"
                            class="form-control form-control-md {{ $errors->has('min_age') ? 'is-invalid':'' }}"
                            id="inputMinAge"
                            placeholder="1"
                            aria-describedby="inputMinAgeFeedback">
                        @error('min_age')
                            <div id="inputMinAgeFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-3">
                   <div class="form-group">
                        <label for="inputMaxAge" class="form-label">Max age *</label>
                        <input wire:model.lazy="max_age"
                            type="number"
                            class="form-control form-control-md {{ $errors->has('max_age') ? 'is-invalid':'' }}"
                            id="inputMaxAge"
                            placeholder="1"
                            aria-describedby="inputMaxAgeFeedback">
                        @error('max_age')
                            <div id="inputMaxAgeFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-3">
                   <div class="form-group">
                        <label for="inputMinDate" class="form-label">Min date *</label>
                        <input wire:model.lazy="min_date"
                            type="date"
                            class="form-control form-control-md {{ $errors->has('min_date') ? 'is-invalid':'' }}"
                            id="inputMinDate"
                            aria-describedby="inputMinDateFeedback">
                        @error('min_date')
                            <div id="inputMinDateFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-3">
                   <div class="form-group">
                        <label for="inputMaxDate" class="form-label">Max date *</label>
                        <input wire:model.lazy="max_date"
                            type="date"
                            class="form-control form-control-md {{ $errors->has('max_date') ? 'is-invalid':'' }}"
                            id="inputMaxDate"
                            aria-describedby="inputMaxDateFeedback">
                        @error('max_date')
                            <div id="inputMaxDateFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Enter symptom (s):</label>
                        <div wire:ignore>
                            <input wire:model="symptoms_terms" id="input-symptoms-terms" value="" autocomplete="off" placeholder="Enter symptom (s)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-6">
                    <div class="form-group">
                        <label>Disease (s):</label>
                        <div wire:ignore>
                            <select id="select-diseases" name="" multiple placeholder="Pick some diseases" autocomplete="off">
                                <option value="">Select a disease...</option>
                                @foreach($diseases as $disease)
                                    <option value="{{$disease->id}}">{{$disease->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label>Treatment term (s):</label>
                        <div wire:ignore>
                            <input wire:model="treatment_terms" id="input-treatment-terms" value="" autocomplete="off" placeholder="Enter treatment terms:">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Attending veterinarian (s):</label>
                        <div wire:ignore>
                            <select id="select-veterinarians" name="" multiple placeholder="Pick some veterinarians" autocomplete="off">
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <!-- Errors -->
                    <ul>
                        @if ($errors->any())
                            <div class="text-sm text-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                    </ul>

                    <!-- ./ Errors -->
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <button type="submit" class="btn bg-gradient-primary btn-block">
                        <span wire:loading.remove wire:target="submit">
                            <i class="fas fa-fw fa-search-plus"></i>
                            Find
                        </span>
                        <span wire:loading wire:target="submit">
                            <i class="fas fa-fw fa-spinner fa-spin"></i>
                            Finding
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>


<div class="card col-md-10 offset-md-1 mt-5 {{ count($consultations) ? 'd-block' : 'd-none' }}">
    <div class="card-header border-0">
        <h3 class="card-title">Results</h3>
        <div class="card-tools">
            <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-bars"></i>
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>AV</th>
                    <th>SPECIES</th>
                    <th>DX</th>
                    {{-- <th>----</th> --}}
                    <th>DATE</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultations as $consultation)
                    <tr>
                        <td>
                            {{-- <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2"> --}}
                            {{ $consultation->user->name }}
                        </td>
                        <td>
                            {{ $consultation->pet->species->name }}
                            <span class="text-muted font-italic">/ {{ $consultation->pet->species->scientific_name }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.pets.consultations.show', ['pet' => $consultation->pet, 'consultation' => $consultation]) }}"
                                class="text-black">
                                {{Str::words(Str::ucfirst($consultation->diseases->implode('name', '; ')), 10, ' >>>') }}
                             </a>
                        </td>
{{--                         <td>
                            <small class="text-success mr-1">
                                <i class="fas fa-arrow-up"></i>
                                12%
                            </small>
                            12,000 Sold
                        </td> --}}
                        <td>
                            {{ $consultation->created_at->format('d-m-Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="col-12 d-flex justify-content-center align-items-center text-muted">
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </p>
                                <p>
                                    There Aren’t Any Great Matches for Your Search
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <span class="float-right">Total results: {{ count($this->consultations) }}</span>
    </div>
</div>



        </div><!-- /.container-fluid -->
    </section>

</div>


<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

{{-- Tom selec: step 1 (Importar CSS y JS) --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

{{-- Tom selec: step 2 (Personalizar estilos) --}}
<style type="text/css">
    .ts-wrapper .option .title {
        display: block;
    }

    .ts-wrapper .option {
        font-size: 15px;
        display: block;
    }

    .ts-wrapper .option .url {
        font-size: 13px;
        display: block;
        color: #a0a0a0;
    }
</style>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){

        {{-- Tom selec: step 3 (Inicializar el input select) --}}
        const mySelect = new TomSelect("#select-species",{
            valueField: 'id',
            searchField: ['title', 'url'],
            maxItems: 8,
            highlight: true,
            openOnFocus: true,
            hideSelected: true,
            hidePlaceholder: true,
            options: [
                @foreach($species as $species_item)
                    {id: {{$species_item->id}}, title: '{{$species_item->name}}', url: '{{$species_item->scientific_name}}'},
                @endforeach
            ],
            render: {
                option: function(data, escape) {
                    return '<div>' +
                            '<span class="title">' + escape(data.title) + '</span>' +
                            '<span class="url">' + escape(data.url) + '</span>' +
                        '</div>';
                },
                item: function(data, escape) {
                    return '<div title="' + escape(data.url) + '">' + escape(data.title) + '</div>';
                }
            },

        });
        {{-- Tom selec: step 4 (Bindear ids seleccionados con la propiedad) --}}
        mySelect.on('change', function(selectedOptions) {
            // Enviar el valor seleccionado a tu componente Livewire
            Livewire.emit('selectedOptionsChanged', selectedOptions);
        });


        const mySelectVeterinarian = new TomSelect("#select-veterinarians",{
            valueField: 'id',
            searchField: 'name',
            maxItems: 8,
            highlight: true,
            openOnFocus: true,
            hideSelected: true,
            hidePlaceholder: true,
            options: [
                @foreach($veterinarians as $veterinarian)
                    {
                        id:    {{ $veterinarian->user->id }},
                        name: '{{ $veterinarian->user->name }}',
                        url:  '{{ $veterinarian->dgp }}',
                    },
                @endforeach
            ],
            // items: [3,4],
            items: [
                @foreach($veterinarians_ids as $id)
                    {{ $id }},
                @endforeach
            ],
            render: {
                option: function(data, escape) {
                    return '<div>' +
                            '<span class="name">' + escape(data.name) + '</span>' +
                            '<span class="url">' + escape(data.url) + '</span>' +
                        '</div>';
                },
                item: function(data, escape) {
                    return '<div name="' + escape(data.url) + '">' + escape(data.name) + '</div>';
                }
            },

        });
        mySelectVeterinarian.on('change', function(selectedOptions) {
            // Enviar el valor seleccionado a tu componente Livewire
            Livewire.emit('selectedVeterinariansChanged', selectedOptions);
        });


        const mySelectDisease = new TomSelect("#select-diseases",{
            maxItems: 5
        });

        mySelectDisease.on('change', function(selectedOptions) {
            // Enviar el valor seleccionado a tu componente Livewire
            Livewire.emit('selectedDiseasesChanged', selectedOptions);
        });

new TomSelect("#input-symptoms-terms",{
    persist: false,
    createOnBlur: true,
    create: true,
    delimiter: ';',
    persist: true,
    options: [
        { value: "Fever", text: "Fever" },
        { value: "Loss of appetite", text: "Loss of appetite" },
        { value: "Depression", text: "Depression" },
        { value: "Suspended rumination", text: "Suspended rumination" },
        { value: "Difficulty breathing", text: "Difficulty breathing" },
        { value: "Coughing", text: "Coughing" },
        { value: "Sneezing", text: "Sneezing" },
        { value: "Nasal discharge", text: "Nasal discharge" },
        { value: "Vomiting", text: "Vomiting" },
        { value: "Diarrhea", text: "Diarrhea" },
        { value: "Loss of appetite", text: "Loss of appetite" },
        { value: "Weight loss", text: "Weight loss" },
        { value: "Fatigue", text: "Fatigue" },
    ]
});


new TomSelect("#input-treatment-terms",{
    persist: false,
    createOnBlur: true,
    create: true,
    delimiter: ';',
    persist: true,
    options: [
        { value: "Pharmacological treatment", text: "Pharmacological treatment" },
        { value: "Surgical treatment", text: "Surgical treatment" },
        { value: "Alternative treatment", text: "Alternative treatment" },
        { value: "Surgical treatment", text: "Surgical treatment" },
        { value: "Hospital treatment", text: "Hospital treatment" },
        { value: "Spaying", text: "Spaying " },
        { value: "Neutering", text: "Neutering" },
        { value: "Hip dysplasia surgery", text: "Hip dysplasia surgery" },
        { value: "Orthopedic surgery", text: "Orthopedic surgery" },
        { value: "Leg amputation", text: "Leg amputation" }
    ]
});


    });
</script>