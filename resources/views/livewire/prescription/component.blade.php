<div {{-- wire:init = "loadItems()" --}}>
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">
                        {{ $pet->name != null ? $pet->name : $pet->code }}'s {{ $pageTitle }}
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.pets.consultations', $pet) }}">Consultations</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.pets.consultations.show', ['pet' => $pet, 'consultation' => $consultation]) }}">#{{ $consultation->id }}</a>
                        </li>
                        <li class="breadcrumb-item active">Prescription</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <!-- Main content -->
{{--     <section class="content">
        <div class="container-fluid">
            <div class="row">

            </div>
        </div>
    </section> --}}

    @can('prescriptions_store')
        <form autocomplete="off" wire:submit.prevent="store()">
            <div class="invoice p-5 mb-3">

                <div class="row mb-3">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-prescription"></i> Prescription
                        </h4>
                    </div>
                </div>

                <div class="row d-flex justify-content-end">
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="table-responsive">
                            <table class="table table-borderless text-sm text-right">
                                <tbody>
                                    <tr>
                                        <th>
                                            <label class="font-weight-normal" for="inputDate">Date: *</label>
                                        </th>
                                        <td>
                                            <input type="date" wire:model.lazy="date" id="inputDate"
                                            class="form-control form-control-sm
                                            {{ $errors->has('date') ? 'is-invalid':'' }}
                                            {{ $errors->has('date') == false && $this->date != null ? 'is-valid border-success':'' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="font-weight-normal" for="inputExpiry">Expiry date:</label>
                                        </th>
                                        <td><input type="date" wire:model.lazy="expiry" id="inputExpiry"
                                            class="form-control form-control-sm
                                            {{ $errors->has('expiry') ? 'is-invalid':'' }}
                                            {{ $errors->has('expiry') == false && $this->expiry != null ? 'is-valid border-success':'' }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="form-row mb-5">
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-normal" for="search">Filter medications:</label>
                        <input class="form-control form-control-sm"
                            id="search"
                            type="search"
                            name="search"
                            wire:model.lazy="search" wire:focusout="getMedicinesProperty"
                            placeholder="i.e. Antibiotics, Amoxicillina">
                    </div>
                </div>

                @foreach($prescribedMedicines as $index => $prescribedMedicine)
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-normal" for="selectPrescribedMedicines.{{$index}}.medicine_id">
                                Medicament <sup>{{ $index+1 }}</sup>
                            </label>
                            <select class="custom-select custom-select-sm
                                {{ $errors->has('prescribedMedicines.'.$index.'.medicine_id') ? 'is-invalid' : '' }}
                                {{ !$errors->has('prescribedMedicines.'.$index.'.medicine_id') && !empty($this->prescribedMedicines[$index]['medicine_id']) ? 'is-valid' : '' }}"
                                name="prescribedMedicines[{{$index}}][medicine_id]"
                                id="selectPrescribedMedicines.{{$index}}.medicine_id"
                                wire:model="prescribedMedicines.{{$index}}.medicine_id"
                                wire:change="setMedicine({{$index}})"
                                {{empty($this->prescribedMedicines[$index]['medicine_id']) ? '':'disabled'}}>
                                <option value="choose">Choose...</option>

                                <optgroup label="Selected Medicines">
                                    @foreach($this->selectedMedicines as $selectedMedicine)
                                        <option value="{{ $selectedMedicine->id }}" disabled>
                                            {{ $selectedMedicine->name }} {{ $selectedMedicine->dosage_form }} {{ $selectedMedicine->strength }}
                                        </option>
                                    @endforeach
                                </optgroup>

                                <optgroup label="Search result">
                                    @foreach($this->medicines as $medicine)
                                        <option value="{{ $medicine->id }}">
                                            {{ $medicine->name }} {{ $medicine->dosage_form }} {{ $medicine->strength }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label class="font-weight-normal" for="inputPrescribedMedicines.{{$index}}.indications_for_owner">
                                Instructions <sup>{{ $index+1 }}</sup>
                            </label>
                            <input class="form-control form-control-sm
                                {{ $errors->has('prescribedMedicines.'.$index.'.indications_for_owner') ? 'is-invalid' : '' }}
                                {{ !$errors->has('prescribedMedicines.'.$index.'.indications_for_owner') && !empty($this->prescribedMedicines[$index]['indications_for_owner']) ? 'is-valid border-success' : '' }}"
                                placeholder="Route of administration: oral; one tablet every 8 hour(s) for 10 day(s); milk withdrawal period: 4 week(s)."
                                type="text"
                                name="prescribedMedicines[{{$index}}][indications_for_owner]"
                                id="inputPrescribedMedicines.{{$index}}.indications_for_owner"
                                wire:model.lazy="prescribedMedicines.{{$index}}.indications_for_owner">
                            {{-- <small class="text-center">Route, dose, frequency, duration and withdrawal period.</small> --}}
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="font-weight-normal" for="inputQrescribedMedicines.{{$index}}.quantity">
                                Quantity <sup>{{ $index+1 }}</sup>
                            </label>
                            <input type="text" class="form-control form-control-sm
                                {{ $errors->has('prescribedMedicines.'.$index.'.quantity') ? 'is-invalid' : '' }}
                                {{ !$errors->has('prescribedMedicines.'.$index.'.quantity') && !empty($this->prescribedMedicines[$index]['quantity']) ? 'is-valid border-success' : '' }}"
                                placeholder="100 ml"
                                name="prescribedMedicines[{{$index}}][quantity]"
                                id="inputQrescribedMedicines.{{$index}}.quantity"
                                wire:model.lazy="prescribedMedicines.{{$index}}.quantity">
                            {{-- <small class="text-center">Quantity and units</small> --}}
                        </div>

                        <div class="col-md-1 mb-3">
                            <label class="font-weight-normal">
                                Remove <sup>{{ $index+1 }}</sup>
                            </label>
                            <a href="javascript:void(0)"
                                class="btn btn-sm btn-block bg-gradient-danger shadow-sm rounded-pill"
                                rel="noopener"
                                target="_blank"
                                wire:click.prevent="removeMedicine({{$index}})">
                                    <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                @endforeach

                <div class="form-group mt-3 mb-5 d-flex justify-content-end">
                    <button
                        wire:click.prevent="addMedicine" wire:loading.attr="disabled"
                        class="btn btn-default btn-lg border-0 rounded-pill" title="Add medicine">

                        <span wire:loading.remove wire:target="addMedicine">
                            <i class="fas fa-fw fa-plus-circle text-info"></i>
                        </span>
                        <span wire:loading wire:target="addMedicine">
                            <i class="fas fa-fw fa-spinner fa-spin"></i>
                        </span>
                        Add medicine
                    </button>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label class="font-weight-normal" for="textareaFurtherInformation">Further information:</label>
                        <textarea wire:model.lazy="further_information" id="textareaFurtherInformation" rows="4"
                             class="form-control form-control-sm
                            {{ $errors->has('further_information') ? 'is-invalid':'' }}
                            {{ $errors->has('further_information') == false && $this->further_information != null ? 'is-valid border-success':'' }}">
                        </textarea>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="table-responsive">
                            <table class="table table-borderless text-sm text-right">
                                <tbody>
                                    <tr>
                                        <th>
                                            <label class="font-weight-normal" for="selectRepeat">Repeat prescription: *</label>
                                        </th>
                                        <td>
                                            <select wire:model.lazy="repeat"
                                                class="custom-select custom-select-sm
                                                {{ $errors->has('repeat') ? 'is-invalid':'' }}
                                                {{ $errors->has('repeat') == false && $this->repeat != 'choose' ? 'is-valid border-success':'' }}"
                                                id="selectRepeat"
                                                aria-describedby="selectRepeatFeedback">
                                                <option value="choose">Choose...</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @if($this->repeat == 1)
                                        <tr>
                                            <th>
                                                <label class="font-weight-normal" for="inputNumberOfRepeats">Number of repeats: *</label>
                                            </th>
                                            <td>
                                                <input  type="number" wire:model.lazy="number_of_repeats" id="inputNumberOfRepeats" name="" class="form-control form-control-sm
                                                    {{ $errors->has('number_of_repeats') ? 'is-invalid':'' }}
                                                    {{ $errors->has('number_of_repeats') == false && $this->number_of_repeats != null ? 'is-valid border-success':'' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label class="font-weight-normal" for="selectIntervalBetweenRepeats">Interval between repeats: *</label>
                                            </th>
                                            <td>
                                                <select wire:model.lazy="interval_between_repeats"
                                                    class="custom-select custom-select-sm
                                                    {{ $errors->has('interval_between_repeats') ? 'is-invalid':'' }}
                                                    {{ $errors->has('interval_between_repeats') == false && $this->interval_between_repeats != null ? 'is-valid border-success':'' }}"
                                                    id="selectIntervalBetweenRepeats"
                                                    aria-describedby="selectIntervalBetweenRepeatsFeedback">

                                                    <option value="" selected>Choose...</option>
                                                    <option value="1 week">1 week</option>
                                                    <option value="2 weeks">2 weeks</option>
                                                    <option value="3 weeks">3 weeks</option>
                                                    <option value="1 month">1 month</option>
                                                    <option value="2 months">2 months</option>
                                                    <option value="3 months">3 months</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-end my-2">
                    @if($errors->any())
                        <ul class="text-sm text-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="row no-print">
                    <div class="col-12">
                        <button type="submit"
                            wire:click.prevent="store" wire:loading.attr="disabled"
                            class="btn btn-success btn-lg rounded-pill float-right col-sm-12 col-md-6 col-lg-3">

                            <span wire:loading.remove wire:target="store">
                            <i class="fas fa-fw fa-save"></i>
                                Save
                            </span>
                            <span wire:loading wire:target="store">
                                <i class="fas fa-fw fa-spinner fa-spin"></i>
                                Save
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endcan


    @foreach($prescriptions as $prescription)
        <div class="invoice p-5 mb-3 {{ $prescription->voided ? 'text-muted' : '' }}" style="text-decoration: {{$prescription->voided ? 'line-through': 'none'}};">

            @if($prescription->voided)
                <div class="ribbon-wrapper ribbon-xl">
                    <div class="ribbon bg-danger text-xl">
                        Voided
                    </div>
                </div>
            @endif

            <!-- Title -->
            <div class="row mb-3">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-prescription"></i> Prescription
                    </h4>
                </div>
            </div>

            <!-- Info -->
            <div class="row invoice-info d-flex justify-content-between text-sm mb-2">
                <div class="col-sm-4 invoice-col py-3">
                    <div>
                        <strong>Vet App, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                        Email: info@vetapp.com
                    </div>
                </div>
                <div class="col-sm-4 invoice-col py-3">
                    <span class="font-weight-bolder">Issued:</span> {{ $prescription->date }} <br>
                    <span class="font-weight-bolder">Expiration:</span> {{ $prescription->expiry }} <br>
                    <span class="font-weight-bolder">Order:</span> #{{ $prescription->order }} <br>
                </div>
            </div>

            <!-- Info part.2  -->
            <div class="row invoice-info text-sm my-2">
                <div class="col-sm-4 invoice-col py-3">
                    From: <strong>{{ $consultation->user->name }}, DVM</strong><br>
                    <div>
                        Phone: {{ $consultation->user->phone }}<br>
                        Email: {{ $consultation->user->email }}<br>
                        License: 20569810
                    </div>
                </div>

                <div class="col-sm-4 invoice-col py-3">
                    Please, supply to: <strong>{{ $pet->user->name }}</strong><br>
                    <div>
                        Phone: {{ $consultation->pet->user->phone }}<br>
                        Email: {{ $consultation->pet->user->email }}
                    </div>
                </div>

                <div class="col-sm-4 invoice-col py-3">
                    For the treatment of: <strong>{{ $pet->name }}</strong><br>
                    <div>
                        Code / ID: {{ $pet->code }}<br>
                        Species: {{ $pet->species->name }} <span class="text-muted font-italic"> / {{ $pet->species->scientific_name }}</span><br>
                        Breed: {{ $pet->breed }} <br>
                        Zootechnical function: {{ $pet->zootechnical_function }} <br>
                        Gender: {{ $pet->sex }} <br>
                        Age: {{ $consultation->age }}
                    </div>
                </div>
            </div>


            <!-- Instruccions -->
            @if(count($prescription->instructions))
                <div class="row mb-3">
                    <div class="col-12 table-responsive d-lg-none">
                        <table class="table table-bordered table-hover text-sm">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>Medication(s) <span class="text-muted font-weight-lighter"> and instructions</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescription->instructions as $instruction)
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="d-flex flex-column text-left mb-0">
                                                    <span class="text-uppercase">
                                                        <span class="font-weight-bolder">
                                                            {{ $instruction->medicine->name }}
                                                            {{ $instruction->medicine->dosage_form }}
                                                            {{ $instruction->medicine->strength }}
                                                        </span>

                                                    </span>
                                                    <span>
                                                        {{ $instruction->indications_for_owner }}
                                                        <span class="text-muted">
                                                        Quantity to Dispense: {{ $instruction->quantity }}
                                                        </span>
                                                    </span>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 table-responsive d-none d-lg-block">
                        <table class="table table-bordered table-hover text-sm">
                            <thead>
                                <tr class="text-uppercase">
                                    <th colspan="3">Medication(s)</th>
                                    <th class="text-center">Instructions</th>
                                    <th class="text-center">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescription->instructions as $instruction)
                                    <tr>
                                        <td class="text-uppercase">
                                            {{ $instruction->medicine->name }}
                                        </td>
                                        <td class="text-center text-uppercase">
                                            {{ $instruction->medicine->dosage_form }}
                                        </td>
                                        <td class="text-center text-uppercase text-nowrap">
                                            {{ $instruction->medicine->strength }}
                                        </td>
                                        <td class="text-center">
                                            {{ $instruction->indications_for_owner }}
                                        </td>
                                        <td class="text-center">
                                            {{ $instruction->quantity }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Further information and repeat prescription -->
            <div class="row mb-3">
                @if($prescription->further_information != '')
                    <div class="col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm text-sm">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="font-weight-bolder text-uppercase text-center">Futher information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $prescription->further_information }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="col-md-6 col-sm-12"></div>
                @endif

                <div class="col-md-6 col-sm-12">
                    {{-- <p class="lead text-center">Repeat prescription</p> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm text-sm">
                            <thead>
                                <tr>
                                    <th colspan="2" class="font-weight-bolder text-uppercase text-center">Repeat prescription</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <th class="text-right">Repeat prescription:</th>
                                    <td>{{ $prescription->repeat ? 'Yes' : 'No' }}</td>
                                </tr>
                                @if($prescription->repeat)
                                    <tr class="text-center">
                                        <th class="text-right">Number of repeats:</th>
                                        <td>{{ $prescription->number_of_repeats }}</td>
                                    </tr>
                                    <tr class="text-center">
                                        <th class="text-right">Interval between repeats:</th>
                                        <td>{{ $prescription->interval_between_repeats }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-12">
                    {{-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> --}}
                    @can('prescriptions_void')
                        <button type="button"
                            wire:click="void({{$prescription->id}})"
                            class="btn btn-danger {{ $prescription->voided ? 'd-none' : '' }} rounded-pill"
                            wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="void">
                                    <i class="fas fa-fw fa-times-circle"></i>
                                </span>
                                <span wire:loading wire:target="void">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i>
                                </span>
                            Void Prescription
                        </button>
                    @endcan
                    @can('prescriptions_export')
                        <button type="button" class="btn btn-primary float-right rounded-pill {{ $prescription->voided ? 'd-none' : '' }}" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    @endforeach
</div>


<script>
    window.addEventListener('not-deleted', event => {
        notify(event)
    });

    window.addEventListener('stored', event => {
        notify(event)
    });

    window.addEventListener('voided', event => {
        notify(event)
    });
</script>



