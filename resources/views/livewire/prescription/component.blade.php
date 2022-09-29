<div {{-- wire:init = "loadItems()" --}}>
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">

            </div>
        </div>
    </section>

    <div class="invoice p-3 mb-3">
        <form autocomplete="off" wire:submit.prevent="store()">
            <div class="row mb-3">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-prescription"></i> Prescription
                    </h4>
                </div>
            </div>

            <div class="row">
                @if($errors->any())
                    <ul class="text-sm text-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="row d-flex justify-content-end">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="table-responsive">
                        <p class="lead">General info:</p>
                        <table class="table table-borderless text-sm text-right">
                            <tbody>
                                <tr>
                                    <th class="text-uppercase">Date: *</th>
                                    <td><input type="date" wire:model.lazy="date" name=""
                                        class="form-control form-control-sm
                                        {{ $errors->has('date') ? 'is-invalid':'' }}
                                        {{ $errors->has('date') == false && $this->date != null ? 'is-valid border-success':'' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase">Expiry date:</th>
                                    <td><input type="date" wire:model.lazy="expiry" name=""
                                        class="form-control form-control-sm
                                        {{ $errors->has('expiry') ? 'is-invalid':'' }}
                                        {{ $errors->has('expiry') == false && $this->expiry != null ? 'is-valid border-success':'' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase">Order number: *</th>
                                    <td><input type="text" wire:model.lazy="order" name=""
                                        class="form-control form-control-sm
                                        {{ $errors->has('order') ? 'is-invalid':'' }}
                                        {{ $errors->has('order') == false && $this->order != null ? 'is-valid border-success':'' }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- <div class="d-lg-none" style="background: red">hide on lg and wider screens</div> --}}
           {{--  <div class="d-none d-lg-block" style="background: blue">hide on screens smaller than lg</div> --}}

            <div class="row">
                <div class="col-12 table-responsive p-0">
                    <p class="lead">Medicines / products:</p>
                    <table class="table table-borderless text-sm text-center">
                        <thead>
                            <tr class="text-uppercase">
                                <th colspan="2" class="text-left">Name *</th>
                                <th width="100px">Quantity *</th>
                                <th>Instructions *</th>
                                <th colspan="sr-only">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prescribedMedicines as $index => $prescribedMedicine)
                            <tr>
                                <td width="10px">
                                    {{$index + 1}}.-
                                </td>
                                <td>
                                    <select class="form-control form-control-sm"
                                        name="prescribedMedicines[{{$index}}][medicine_id]"
                                        wire:model.lazy="prescribedMedicines.{{$index}}.medicine_id">
                                        <option value="choose">Choose...</option>
                                        @foreach($allMedicines as $medicine)
                                            <option value="{{ $medicine->id }}">
                                                {{ $medicine->name }}, {{ $medicine->strength }}-{{ $medicine->dosage_form }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm"
                                        name="prescribedMedicines[{{$index}}][quantity]"
                                        wire:model.lazy="prescribedMedicines.{{$index}}.quantity">
                                </td>
                                <td>
                                    <input class="form-control form-control-sm" type="text"
                                        name="prescribedMedicines[{{$index}}][indications_for_owner]"
                                        wire:model.lazy="prescribedMedicines.{{$index}}.indications_for_owner">
                                </td>
                                <td width="10px">
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-link border border-0"
                                        rel="noopener"
                                        target="_blank"
                                        wire:click.prevent="removeMedicine({{$index}})">
                                            <i class="fas fa-trash text-muted"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button
                        wire:click.prevent="addMedicine" wire:loading.attr="disabled"
                        class="btn btn-default btn-lg border-0 rounded-pill float-right" title="Add medicine">

                        <span wire:loading.remove wire:target="addMedicine">
                            <i class="fas fa-fw fa-plus-circle text-info"></i>
                        </span>
                        <span wire:loading wire:target="addMedicine">
                            <i class="fas fa-fw fa-spinner fa-spin"></i>
                        </span>
                        Add medicine
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <p class="lead">Futher information:</p>
                    <textarea wire:model.lazy="further_information" rows="7"
                         class="form-control form-control-sm
                        {{ $errors->has('further_information') ? 'is-invalid':'' }}
                        {{ $errors->has('further_information') == false && $this->further_information != null ? 'is-valid border-success':'' }}">
                    </textarea>
                </div>
                <div class="col-sm-12 col-md-6">
                    <p class="lead">Repeat prescription</p>
                    <div class="table-responsive">
                        <table class="table table-borderless text-sm text-right">
                            <tbody>
                                <tr>
                                    <th class="text-uppercase">Repeat prescription: *</th>
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
                                <tr>
                                    <th class="text-uppercase">Number of repeats:</th>
                                    <td>
                                        <input  type="text" wire:model.lazy="number_of_repeats" name="" class="form-control form-control-sm
                                            {{ $errors->has('number_of_repeats') ? 'is-invalid':'' }}
                                            {{ $errors->has('number_of_repeats') == false && $this->number_of_repeats != null ? 'is-valid border-success':'' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase">Interval between repeats:</th>
                                    <td>
                                        <input  type="text" wire:model.lazy="interval_between_repeats" name="" class="form-control form-control-sm
                                            {{ $errors->has('interval_between_repeats') ? 'is-invalid':'' }}
                                            {{ $errors->has('interval_between_repeats') == false && $this->interval_between_repeats != null ? 'is-valid border-success':'' }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
        </form>
    </div>


    @foreach($prescriptions as $prescription)
        <div class="invoice p-3 mb-3">
            <div class="row mb-3">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-prescription"></i> Prescription
                    </h4>
                </div>
            </div>

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

            <div class="row invoice-info text-sm my-2">
                <div class="col-sm-4 invoice-col py-3">
                    From:
                    <div>
                        <strong>{{ $consultation->user->name }}, DVM</strong><br>
                        Phone: {{ $consultation->user->phone }}<br>
                        Email: {{ $consultation->user->email }}<br>
                        License: 20569810
                    </div>
                </div>

                <div class="col-sm-4 invoice-col py-3">
                    Please, supply to:
                    <div>
                        <strong>{{ $consultation->pet->user->name }}</strong><br>
                        Phone: {{ $consultation->pet->user->phone }}<br>
                        Email: {{ $consultation->pet->user->email }}
                    </div>
                </div>

                <div class="col-sm-4 invoice-col py-3">
                    For the treatment of:
                    <div>
                        <strong>{{ $pet->name }}</strong><br>
                        Code / ID: {{ $pet->code }}<br>
                        Species: {{ $pet->species->name }} ({{ $pet->species->scientific_name }})<br>
                        Breed: {{ $pet->breed }} <br>
                        Gender: {{ $pet->sex }} <br>
                        Age: {{ $consultation->age }}
                    </div>
                </div>
            </div>

            @if(count($prescription->instructions))
                <div class="row">
                    <div class="col-12 table-responsive">
                        <p class="lead">Medicines / products:</p>
                        <table class="table table-borderless table-hover text-sm">
                            <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th>Strenght</th>
                                    <th>Form</th>
                                    <th>Quantity</th>
                                    <th>Instructions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescription->instructions as $instruction)
                                    <tr>
                                        <td>{{ $instruction->medicine->name }}</td>
                                        <td>{{ $instruction->medicine->strength }}</td>
                                        <td>{{ $instruction->medicine->dosage_form }}</td>
                                        <td>{{ $instruction->quantity }}</td>
                                        <td>{{ $instruction->indications_for_owner }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif


                <div class="row">
                    @if($prescription->further_information != '')
                        <div class="col-6">
                            <p class="lead">Futher information:</p>
                            <p class="well well-sm shadow-none text-sm" style="margin-top: 10px;">
                                {{ $prescription->further_information }}
                            </p>
                        </div>
                    @else
                        <div class="col-6"></div>
                    @endif

                    <div class="col-6">
                        <p class="lead">Repeat prescription</p>
                        <div class="table-responsive">
                            <table class="table table-bordered text-sm">
                                <tbody>
                                    <tr>
                                        <th>Repeat prescription:</th>
                                        <td>{{ $prescription->repeat ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Number of repeats:</th>
                                        <td>{{ $prescription->number_of_repeats }}</td>
                                    </tr>
                                    <tr>
                                        <th>Interval between repeats:</th>
                                        <td>{{ $prescription->interval_between_repeats }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <div class="row no-print">
                <div class="col-12">
                    <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                    <button type="button" class="btn btn-success float-right">
                        <i class="far fa-credit-card"></i> Submit Payment
                    </button>
                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-download"></i> Generate PDF
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>


<script>
    window.addEventListener('not-deleted', event => {
        notify(event)
    });
</script>