<form autocomplete="off" wire:submit.prevent="submit">
    @include('common.modal-header')
                <!-- Card body -->
                    <div class="container">
                        <div class="row d-flex flex-wrap justify-content-around align-self-center text-center">
                            @for($i = 1; $i < 6; $i++ )
                                <div class="col-2">
                                    <span class="badge {{ $this->currentStep > $i ? 'badge-success' : '' }} {{ $this->currentStep == $i ? 'badge-primary' : '' }} {{ $this->currentStep < $i ? 'badge-secondary' : '' }}">
                                        {{ $i }}
                                    </span>
                                    <span class="d-none d-md-block">{{ $this->steps[$i] ['heading'] }}</span>
                                </div>
                            @endfor
                            <div class="col-12">
                                <span class="d-md-none mt-3">{{ $this->steps[$this->currentStep] ['heading'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress bar stteper -->
                    <div class="progress progress-sm mb-3 mt-2">
                        <div class="progress-bar progress-bar-striped {{ $this->currentStep < $totalSteps ? 'bg-info' : 'bg-success'}}" role="progressbar" aria-valuenow="{{ ($this->currentStep/count($this->steps)) * 100 }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($this->currentStep/count($this->steps)) * 100}}%">
                            <span class="sr-only">{{ ($this->currentStep/count($this->steps)) * 100}}% Complete</span>
                        </div>
                    </div>

                    <!-- Steps -->
                    @if($this->currentStep === 1)
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputAge" class="form-label font-weight-normal">Age *</label>
                                <input wire:model.lazy="age"
                                    type="text"
                                    class="form-control form-control-sm
                                    {{ $errors->has('age') ? 'is-invalid':'' }}
                                    {{ $errors->has('age') == false && $this->age != null ? 'is-valid border-success':'' }}"
                                    id="inputAge"
                                    placeholder="e.g. 3 months old"
                                    aria-describedby="inputAgeFeedback"
                                    readonly
                                    disabled>

{{--                                 @error('age')
                                    <div id="inputAgeFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="inputAgeFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputWeight" class="form-label font-weight-normal">Weight (kg) *</label>
                                <input wire:model.lazy="weight"
                                    type="number"
                                    class="form-control form-control-sm
                                    {{ $errors->has('weight') ? 'is-invalid':'' }}
                                    {{ $errors->has('weight') == false && $this->weight != null ? 'is-valid border-success':'' }}"
                                    id="inputWeight"
                                    placeholder="e.g. 30.250"
                                    aria-describedby="inputWeightFeedback">

{{--                                 @error('weight')
                                    <div id="inputWeightFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="inputWeightFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputTemperature" class="form-label font-weight-normal">Temperature (°c) *</label>
                                <input wire:model.lazy="temperature"
                                    type="number"
                                    class="form-control form-control-sm
                                    {{ $errors->has('temperature') ? 'is-invalid':'' }}
                                    {{ $errors->has('temperature') == false && $this->temperature != null ? 'is-valid border-success':'' }}"
                                    id="inputTemperature"
                                    placeholder="e.g. 38.5"
                                    aria-describedby="inputTemperatureFeedback">

 {{--                                @error('temperature')
                                    <div id="inputTemperatureFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="inputTemperatureFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputHeartRate" class="form-label font-weight-normal">Heart rate (bpm) *</label>
                                <input wire:model.lazy="heart_rate"
                                    type="number"
                                    class="form-control form-control-sm
                                    {{ $errors->has('heart_rate') ? 'is-invalid':'' }}
                                    {{ $errors->has('heart_rate') == false && $this->heart_rate != null ? 'is-valid border-success':'' }}"
                                    id="inputHeartRate"
                                    placeholder="e.g. 65"
                                    aria-describedby="inputHeartRateFeedback">

 {{--                                @error('heart_rate')
                                    <div id="inputHeartRateFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="inputHeartRateFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>
                        </div>
                        <!-- /. row -->

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputOxygenSaturationLevel" class="form-label font-weight-normal">Oxygen saturation level (%)</label>
                                <input wire:model.lazy="oxygen_saturation_level"
                                    type="number"
                                    class="form-control form-control-sm
                                    {{ $errors->has('oxygen_saturation_level') ? 'is-invalid':'' }}
                                    {{ $errors->has('oxygen_saturation_level') == false && $this->oxygen_saturation_level != null ? 'is-valid border-success':'' }}"
                                    id="inputOxygenSaturationLevel"
                                    placeholder="e.g. 98"
                                    aria-describedby="inputOxygenSaturationLevelFeedback">

{{--                                 @error('oxygen_saturation_level')
                                    <div id="inputOxygenSaturationLevelFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="inputOxygenSaturationLevelFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputRespiratoryRate" class="form-label font-weight-normal">Respiratory rate (bpm) *</label>
                                <input wire:model.lazy="respiratory_rate"
                                    type="number"
                                    class="form-control form-control-sm
                                    {{ $errors->has('respiratory_rate') ? 'is-invalid':'' }}
                                    {{ $errors->has('respiratory_rate') == false && $this->respiratory_rate != null ? 'is-valid border-success':'' }}"
                                    id="inputRespiratoryRate"
                                    placeholder="e.g. 30"
                                    aria-describedby="inputRespiratoryRateFeedback">

{{--                                 @error('respiratory_rate')
                                    <div id="inputRespiratoryRateFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="inputRespiratoryRateFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-3">
                                <label for="selectCapillaryRefillTime" class="form-label font-weight-normal">Capillary refill time (crt) *</label>
                                <select wire:model.lazy="capillary_refill_time"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('capillary_refill_time') ? 'is-invalid':'' }}
                                    {{ $errors->has('capillary_refill_time') == false && $this->capillary_refill_time != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectCapillaryRefillTime"
                                    aria-describedby="selectCapillaryRefillTimeFeedback">
                                    <option value="choose" selected>Choose...</option>
                                    <option value="Less than 1 second">Less than 1 second</option>
                                    <option value="1-2 seconds">1-2 seconds</option>
                                    <option value="Longer than 2 seconds">Longer than 2 seconds</option>
                                </select>

 {{--                                @error('capillary_refill_time')
                                    <div id="selectCapillaryRefillTimeFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectCapillaryRefillTimeFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-3">
                                <label for="selectPulse" class="form-label font-weight-normal">Pulse *</label>
                                <select wire:model.lazy="pulse"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('pulse') ? 'is-invalid':'' }}
                                    {{ $errors->has('pulse') == false && $this->pulse != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectPulse"
                                    aria-describedby="selectPulseFeedback">
                                    <option value="choose" selected>Choose...</option>
                                    <option value="Strong and synchronous with each heart beat">Strong and synchronous with each heart beat</option>
                                    <option value="Irregular">Irregular</option>
                                    <option value="Bounding">Bounding</option>
                                    <option value="Weak or absent">Weak or absent</option>
                                </select>

{{--                                 @error('pulse')
                                    <div id="selectPulseFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectPulseFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>
                        </div>
                        <!-- /. row -->
                    @endif

                    @if($this->currentStep === 2)
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="selectReproductiveStatus" class="form-label font-weight-normal">Reproductive status *</label>
                                <select wire:model.lazy="reproductive_status"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('reproductive_status') ? 'is-invalid':'' }}
                                    {{ $errors->has('reproductive_status') == false && $this->reproductive_status != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectReproductiveStatus"
                                    aria-describedby="selectReproductiveStatusFeedback">
                                    <option value="choose" selected>Choose...</option>
                                    <option value="Pregnant" {{ $pet->sex != 'Female' ? 'disabled' : '' }}>Pregnant</option>
                                    <option value="Lactating" {{ $pet->sex != 'Female' ? 'disabled' : '' }}>Lactating</option>
                                    <option value="Neither">Neither</option>
                                </select>

{{--                                 @error('reproductive_status')
                                    <div id="selectReproductiveStatusFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectReproductiveStatusFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-6">
                                <label for="selectConsciousness" class="form-label font-weight-normal">Consciousness *</label>
                                <select wire:model.lazy="consciousness"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('consciousness') ? 'is-invalid':'' }}
                                    {{ $errors->has('consciousness') == false && $this->consciousness != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectConsciousness"
                                    aria-describedby="selectConsciousnessFeedback">
                                    <option value="choose" selected>Choose...</option>
                                    <option value="Alert and responsive">Alert and responsive</option>
                                    <option value="Depressed or obtunded">Depressed or obtunded</option>
                                    <option value="Stupor">Stupor</option>
                                    <option value="Comatose">Comatose</option>
                                </select>

{{--                                 @error('consciousness')
                                    <div id="selectConsciousnessFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectConsciousnessFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>
                        </div>
                        <!-- /. row -->

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="selectHydration" class="form-label font-weight-normal">Hydration *</label>
                                <select wire:model.lazy="hydration"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('hydration') ? 'is-invalid':'' }}
                                    {{ $errors->has('hydration') == false && $this->hydration != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectHydration"
                                    aria-describedby="selectHydrationFeedback">
                                    <option value="choose" selected>Choose...</option>
                                    <option value="Normal">Normal</option>
                                    <option value="0-5%">0-5%</option>
                                    <option value="6-7%">6-7%</option>
                                    <option value="8-9%">8-9%</option>
                                    <option value="+10%">+10%</option>
                                </select>

{{--                                 @error('hydration')
                                    <div id="selectHydrationFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectHydrationFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-4">
                                <label for="selectPain" class="form-label font-weight-normal">Pain *</label>
                                <select wire:model.lazy="pain"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('pain') ? 'is-invalid':'' }}
                                    {{ $errors->has('pain') == false && $this->pain != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectPain"
                                    aria-describedby="selectPainFeedback">
                                    <option value="choose" selected>Choose...</option>
                                    <option value="None">None</option>
                                    <option value="Vocalization">Vocalization</option>
                                    <option value="Changes in behavior">Changes in behavior</option>
                                    <option value="Physical changes">Physical changes</option>
                                </select>

{{--                                 @error('pain')
                                    <div id="selectPainFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectPainFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>

                            <div class="form-group col-md-4">
                                <label for="selectBodyCondition" class="form-label font-weight-normal">Body condition *</label>
                                <select wire:model.lazy="body_condition"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('body_condition') ? 'is-invalid':'' }}
                                    {{ $errors->has('body_condition') == false && $this->body_condition != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectBodyCondition"
                                    aria-describedby="selectBodyConditionFeedback">
                                    <option value="choose" selected>Choose...</option>
                                    <option value="Very thin">Very thin</option>
                                    <option value="Thin">Thin</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Fat">Fat</option>
                                    <option value="Very fat">Very fat</option>
                                </select>

{{--                                 @error('body_condition')
                                    <div id="selectBodyConditionFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectBodyConditionFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>
                        </div>
                        <!-- /. row -->
                    @endif

                    @if($this->currentStep === 3)
{{--                         <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="textareaProblemStatement"class="form-label font-weight-normal">Problem statement *</label>
                                <div x-data x-init="
                                    ClassicEditor.create($refs.editor)
                                        .then(editor => {
                                            editor.model.document.on('change:data', () => {
                                                @this.set('problem_statement', editor.getData())
                                            })
                                        })
                                " wire:ignore>
                                    <textarea x-ref="editor" wire:model.lazy="problem_statement">{{ $this->problem_statement }}</textarea>
                                </div>
                            </div>
                        </div> --}}


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="textareaProblemStatement"class="form-label font-weight-normal">Problem statement *</label>
                                <div x-data x-init="
                                    ClassicEditor.create($refs.editor, {
                                        heading: {
                                            options: [
                                                { model: 'heading4', view: 'h4', title: 'Title', class: 'ck-heading_heading4' },
                                                { model: 'heading5', view: 'h5', title: 'Subtitle', class: 'ck-heading_heading5' },
                                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                            ]
                                        },
                                    })
                                    .then(editor => {
                                        editor.model.document.on('change:data', () => {
                                            @this.set('problem_statement', editor.getData())
                                        })
                                    })
                                    "
                                wire:ignore>
                                    <textarea x-ref="editor" wire:model.lazy="problem_statement">{{ $this->problem_statement }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($this->currentStep === 4 || $this->currentStep === 5)
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="textareaDisease"class="form-label font-weight-normal">Diagnosis *</label>
                                <textarea wire:model.lazy="disease"
                                    class="form-control form-control-sm
                                    {{ $errors->has('disease') ? 'is-invalid':'' }}
                                    {{ $errors->has('disease') == false && $this->disease != null ? 'is-valid border-success':'' }}"
                                    id="textareaDisease"
                                    placeholder="e.g. Pyometra; necrosis and fatty degeneration, difuse, severe, liver."
                                    aria-describedby="textareaDiseaseFeedback"
                                    rows="1"
                                    {{ $this->currentStep === 5 ? 'readonly' : '' }}>
                                </textarea>
                            </div>

{{--                             <div class="form-group col-md-4">
                                <label for="selectTypesOfDiagnosis" class="form-label font-weight-normal">Type(s) of diagnosis *</label>
                                <select wire:model.lazy="types_of_diagnosis"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('types_of_diagnosis') ? 'is-invalid':'' }}
                                    {{ $errors->has('types_of_diagnosis') == false && $this->types_of_diagnosis != null ? 'is-valid border-success':'' }}"
                                    id="selectTypesOfDiagnosis"
                                    aria-describedby="selectTypesOfDiagnosisFeedback" multiple size="7"
                                    {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                    <option value="Clinical">Clinical diagnosis</option>
                                    <option value="Presumptive">Presumptive diagnosis</option>
                                    <option value="Laboratory">Laboratory diagnosis</option>
                                    <option value="Radiology or tissue">Radiology or tissue diagnosis</option>
                                    <option value="Principal">Principal diagnosis</option>
                                    <option value="Admitting">Admitting diagnosis</option>
                                    <option value="Other">Other diagnosis</option>
                                </select>

                                 @error('types_of_diagnosis')
                                    <div id="selectTypesOfDiagnosisFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectTypesOfDiagnosisFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror
                            </div> --}}


                            <div class="form-group col-md-6">
                                <label for="selectPrognosis" class="form-label font-weight-normal">Prognosis *</label>
                                <select wire:model.lazy="prognosis"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('prognosis') ? 'is-invalid':'' }}
                                    {{ $errors->has('prognosis') == false && $this->prognosis != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectPrognosis"
                                    aria-describedby="selectPrognosisFeedback"
                                    {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                    <option value="choose">Choose...</option>
                                    <option selected value="Pending">Pending</option>
                                    <option value="Good">Good</option>
                                    <option value="Fair">Fair</option>
                                    <option value="Guarded">Guarded</option>
                                    <option value="Grave">Grave</option>
                                    <option value="Poor">Poor</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label font-weight-normal"> Types of diagnosis *</label>
                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="icheck-greensea">
                                            <input class="form-check-input  {{ $errors->has('types_of_diagnosis') ? 'is-invalid':'' }}
                                                {{ $errors->has('types_of_diagnosis.*') == false && $this->types_of_diagnosis != null ? 'is-valid border-success':'' }}"
                                                type="checkbox"
                                                id="inlineCheckboxClinical"
                                                wire:model.defer="types_of_diagnosis"
                                                value="Clinical"
                                                aria-describedby="selectTypesOfDiagnosisFeedback" {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                            <label class="form-check-label" for="inlineCheckboxClinical">
                                                Clinical
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="icheck-greensea">
                                            <input class="form-check-input  {{ $errors->has('types_of_diagnosis') ? 'is-invalid':'' }}
                                                {{ $errors->has('types_of_diagnosis.*') == false && $this->types_of_diagnosis != null ? 'is-valid border-success':'' }}"
                                                type="checkbox"
                                                id="inlineCheckboxPresumptive"
                                                wire:model.defer="types_of_diagnosis"
                                                value="Presumptive"
                                                aria-describedby="selectTypesOfDiagnosisFeedback" {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                            <label class="form-check-label" for="inlineCheckboxPresumptive">
                                                Presumptive
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                       <div class="icheck-greensea">
                                            <input class="form-check-input  {{ $errors->has('types_of_diagnosis') ? 'is-invalid':'' }}
                                                {{ $errors->has('types_of_diagnosis.*') == false && $this->types_of_diagnosis != null ? 'is-valid border-success':'' }}"
                                                type="checkbox"
                                                id="inlineCheckboxLaboratory"
                                                wire:model.defer="types_of_diagnosis"
                                                value="Laboratory"
                                                aria-describedby="selectTypesOfDiagnosisFeedback" {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                            <label class="form-check-label" for="inlineCheckboxLaboratory">
                                                Laboratory
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                       <div class="icheck-greensea">
                                            <input class="form-check-input  {{ $errors->has('types_of_diagnosis') ? 'is-invalid':'' }}
                                                {{ $errors->has('types_of_diagnosis.*') == false && $this->types_of_diagnosis != null ? 'is-valid border-success':'' }}"
                                                type="checkbox"
                                                id="inlineCheckboxRadiology"
                                                wire:model.defer="types_of_diagnosis"
                                                value="Radiology or tissue"
                                                aria-describedby="selectTypesOfDiagnosisFeedback" {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                            <label class="form-check-label" for="inlineCheckboxRadiology">
                                                Radiology or tissue
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                       <div class="icheck-greensea">
                                            <input class="form-check-input  {{ $errors->has('types_of_diagnosis') ? 'is-invalid':'' }}
                                                {{ $errors->has('types_of_diagnosis.*') == false && $this->types_of_diagnosis != null ? 'is-valid border-success':'' }}"
                                                type="checkbox"
                                                id="inlineCheckboxPrincipal"
                                                wire:model.defer="types_of_diagnosis"
                                                value="Principal"
                                                aria-describedby="selectTypesOfDiagnosisFeedback" {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                            <label class="form-check-label" for="inlineCheckboxPrincipal">
                                                Principal
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="icheck-greensea">
                                            <input class="form-check-input  {{ $errors->has('types_of_diagnosis') ? 'is-invalid':'' }}
                                                {{ $errors->has('types_of_diagnosis.*') == false && $this->types_of_diagnosis != null ? 'is-valid border-success':'' }}"
                                                type="checkbox"
                                                id="inlineCheckboxAdmitting"
                                                wire:model.defer="types_of_diagnosis"
                                                value="Admitting"
                                                aria-describedby="selectTypesOfDiagnosisFeedback" {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                            <label class="form-check-label" for="inlineCheckboxAdmitting">
                                                Admitting
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="icheck-greensea">
                                            <input class="form-check-input  {{ $errors->has('types_of_diagnosis') ? 'is-invalid':'' }}
                                                {{ $errors->has('types_of_diagnosis.*') == false && $this->types_of_diagnosis != null ? 'is-valid border-success':'' }}"
                                                type="checkbox"
                                                id="inlineCheckboxOther"
                                                wire:model.defer="types_of_diagnosis"
                                                value="Other"
                                                aria-describedby="selectTypesOfDiagnosisFeedback" {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                            <label class="form-check-label" for="inlineCheckboxOther">
                                                Other
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="textareaTreatmentPlan"class="form-label font-weight-normal">Treatment Plan </label>
                                <div x-data x-init="
                                    ClassicEditor.create($refs.editorTreatmentPlan, {
                                        heading: {
                                            options: [
                                                { model: 'heading5', view: 'h5', title: 'Subtitle', class: 'ck-heading_heading5' },
                                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                            ]
                                        },
                                        toolbar: ['undo', 'redo', '|', 'heading', 'bold', 'italic', '|', 'numberedList', 'bulletedList' ],
                                    })
                                    .then(editorTreatmentPlan => {
                                        editorTreatmentPlan.model.document.on('change:data', () => {
                                            @this.set('treatment_plan', editorTreatmentPlan.getData())
                                        })
                                    })
                                    "
                                wire:ignore>
                                    <textarea x-ref="editorTreatmentPlan" wire:model.lazy="treatment_plan">
                                        {{ $this->treatment_plan }}
                                    </textarea>
                                </div>
                            </div>
                        </div>

{{--                         <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="textareaTreatmentPlan" class="form-label font-weight-normal">
                                    Treatment plan
                                </label>

                                <textarea wire:model.lazy="treatment_plan"
                                    class="form-control form-control-sm
                                    {{ $errors->has('treatment_plan') ? 'is-invalid':'' }}
                                    {{ $errors->has('treatment_plan') == false && $this->treatment_plan != null ? 'is-valid border-success':'' }}"
                                    id="textareaTreatmentPlan"
                                    placeholder="e.g. (1) Hospitalization, (2) Surgery, (3) medications, (4) medical progress exams."
                                    aria-describedby="textareaTreatmentPlanFeedback"
                                    rows="4"
                                    {{ $this->currentStep === 5 ? 'readonly' : '' }}>
                                </textarea>

                                @error('treatment_plan')
                                    <div id="textareaTreatmentPlanFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="textareaTreatmentPlanFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-row d-flex justify-content-end">
                            <div class="form-group col-md-3">
                                <label for="selectConsultStatus" class="form-label font-weight-normal">Consult status *</label>
                                <select wire:model.lazy="consult_status"
                                    class="custom-select custom-select-sm
                                    {{ $errors->has('consult_status') ? 'is-invalid':'' }}
                                    {{ $errors->has('consult_status') == false && $this->consult_status != 'choose' ? 'is-valid border-success':'' }}"
                                    id="selectConsultStatus"
                                    aria-describedby="selectConsultStatusFeedback"
                                    {{ $this->currentStep === 5 ? 'disabled' : '' }}>
                                    <option value="choose" selected>Choose...</option>
                                    <option value="In process">In process</option>
                                    <option value="Closed">Closed</option>
                                </select>

{{--                                 @error('consult_status')
                                    <div id="selectConsultStatusFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div id="selectConsultStatusFeedback" class="valid-feedback">
                                        Looks good!
                                    </div>
                                @enderror --}}
                            </div>
                        </div>
                    @endif
                    <!-- ./ Steps -->


                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <!-- Overlay -->
                    <div wire:loading.class="overlay dark" wire:target="goToPreviousStep, goToNextStep, store, update">
                        <div class="" wire:loading wire:target="goToPreviousStep, goToNextStep, store, update">
                            <div class="d-flex justify-content-center"><span class="loader"></span></div>
                            @if($this->currentStep == $this->totalSteps)
                                <div class="text-xl lead font-weight-bold">{{ $this->selected_id ? 'Updating...' : 'Saving...'}}</div>
                            @endif
                        </div>
                    </div>
                    <!-- ./ Overlay -->

                    @if ($errors->any())
                        <div class="text-sm text-danger">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif
                    <!-- ./ Errors -->

                    @if($this->currentStep === 1)
                        <div></div>
                    @endif

                    <!-- Back button -->
                    @if($this->currentStep === 2 || $this->currentStep === 3 || $this->currentStep === 4 || $this->currentStep === 5)
                        <button class="btn btn-light" type="button"
                            wire:click.prevent="goToPreviousStep">
                                <i class="fas fa-chevron-left text-xs"></i> Back
                        </button>
                    @endif

                    <!-- Next button -->
                    @if($this->currentStep === 1 || $this->currentStep === 2 || $this->currentStep === 3 || $this->currentStep === 4)
                        <button class="btn btn-light" type="button"
                            wire:click.prevent="goToNextStep">
                                Next <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    @endif

                    @if($this->currentStep === 5)
                        <button type="button" wire:click.prevent="resetUI()" class="btn bg-gradient-danger" data-dismiss="modal">
                            Close
                        </button>

                        <button type="submit"
                            {{ $selected_id > 0 ? '' : 'hidden' }}
                            wire:click.prevent="update" wire:loading.attr="disabled"
                            class="btn bg-gradient-primary">

                            <span wire:loading.remove wire:target="update">
                                <i class="fas fa-fw fa-edit"></i>
                                Update
                            </span>
                            <span wire:loading wire:target="update">
                                <i class="fas fa-fw fa-spinner fa-spin"></i>
                                Update
                            </span>
                        </button>

                        <button type="submit"
                            {{ $selected_id > 0 ? 'hidden' : '' }}
                            wire:click.prevent="store" wire:loading.attr="disabled"
                            class="btn bg-gradient-primary">

                            <span wire:loading.remove wire:target="store">
                                <i class="fas fa-fw fa-save"></i>
                                Save
                            </span>
                            <span wire:loading wire:target="store">
                                <i class="fas fa-fw fa-spinner fa-spin"></i>
                                Save
                            </span>
                        </button>
                    @endif
                </div>
                <!-- ./ Footer -->
            </div>
        </div>
    </div>
</form>