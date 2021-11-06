<form wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
	@include('common.modal-header')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputAge" class="form-label font-weight-normal">Age *</label>
                        <input wire:model.lazy="age"
                            type="text"
                            class="form-control form-control-sm {{ $errors->has('age') ? 'is-invalid':'' }}"
                            id="inputAge"
                            placeholder="e.g. 3 months old"
                            aria-describedby="inputAgeFeedback">

                        @error('age')
                            <div id="inputAgeFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputWeight" class="form-label font-weight-normal">Weight (kg) *</label>
                        <input wire:model.lazy="weight"
                            type="number"
                            class="form-control form-control-sm {{ $errors->has('weight') ? 'is-invalid':'' }}"
                            id="inputWeight"
                            placeholder="e.g. 30.250"
                            aria-describedby="inputWeightFeedback">

                        @error('weight')
                            <div id="inputWeightFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputTemperature" class="form-label font-weight-normal">Temperature (°c) *</label>
                        <input wire:model.lazy="temperature"
                            type="number"
                            class="form-control form-control-sm {{ $errors->has('temperature') ? 'is-invalid':'' }}"
                            id="inputTemperature"
                            placeholder="e.g. 38.5"
                            aria-describedby="inputTemperatureFeedback">

                        @error('temperature')
                            <div id="inputTemperatureFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputHeartRate" class="form-label font-weight-normal">Heart rate (bps) *</label>
                        <input wire:model.lazy="heart_rate"
                            type="number"
                            class="form-control form-control-sm {{ $errors->has('heart_rate') ? 'is-invalid':'' }}"
                            id="inputHeartRate"
                            placeholder="e.g. 65"
                            aria-describedby="inputHeartRateFeedback">

                        @error('heart_rate')
                            <div id="inputHeartRateFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <!-- /. row -->

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputRespiratoryRate" class="form-label font-weight-normal">Respiratory rate (bps) *</label>
                        <input wire:model.lazy="respiratory_rate"
                            type="number"
                            class="form-control form-control-sm {{ $errors->has('respiratory_rate') ? 'is-invalid':'' }}"
                            id="inputRespiratoryRate"
                            placeholder="e.g. 30"
                            aria-describedby="inputRespiratoryRateFeedback">

                        @error('respiratory_rate')
                            <div id="inputRespiratoryRateFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="selectCapillaryRefillTime" class="form-label font-weight-normal">Capillary refill time (crt) *</label>
                        <select wire:model.lazy="capillary_refill_time"
                            class="custom-select custom-select-sm {{ $errors->has('capillary_refill_time') ? 'is-invalid':'' }}"
                            id="selectCapillaryRefillTime"
                            aria-describedby="selectCapillaryRefillTimeFeedback">
                            <option value="choose" selected>Choose...</option>
                            <option value="Less than 1 second">Less than 1 second</option>
                            <option value="1-2 seconds">1-2 seconds</option>
                            <option value="Longer than 2 seconds">Longer than 2 seconds</option>
                        </select>

                        @error('capillary_refill_time')
                            <div id="selectCapillaryRefillTimeFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-5">
                        <label for="selectPulse" class="form-label font-weight-normal">Pulse *</label>
                        <select wire:model.lazy="pulse"
                            class="custom-select custom-select-sm {{ $errors->has('pulse') ? 'is-invalid':'' }}"
                            id="selectPulse"
                            aria-describedby="selectPulseFeedback">
                            <option value="choose" selected>Choose...</option>
                            <option value="Strong and synchronous with each heart beat">Strong and synchronous with each heart beat</option>
                            <option value="Irregular">Irregular</option>
                            <option value="Bounding">Bounding</option>
                            <option value="Weak or absent">Weak or absent</option>
                        </select>

                        @error('pulse')
                            <div id="selectPulseFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <!-- /. row -->

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="selectReproductiveStatus" class="form-label font-weight-normal">Reproductive status *</label>
                        <select wire:model.lazy="reproductive_status"
                            class="custom-select custom-select-sm {{ $errors->has('reproductive_status') ? 'is-invalid':'' }}"
                            id="selectReproductiveStatus"
                            aria-describedby="selectReproductiveStatusFeedback">
                            <option value="choose" selected>Choose...</option>
                            <option value="Pregnant">Pregnant</option>
                            <option value="Lactating">Lactating</option>
                            <option value="Neither">Neither</option>
                        </select>

                        @error('reproductive_status')
                            <div id="selectReproductiveStatusFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="selectConsciousness" class="form-label font-weight-normal">Consciousness *</label>
                        <select wire:model.lazy="consciousness"
                            class="custom-select custom-select-sm {{ $errors->has('consciousness') ? 'is-invalid':'' }}"
                            id="selectConsciousness"
                            aria-describedby="selectConsciousnessFeedback">
                            <option value="choose" selected>Choose...</option>
                            <option value="Alert and responsive">Alert and responsive</option>
                            <option value="Depressed or obtunded">Depressed or obtunded</option>
                            <option value="Stupor">Stupor</option>
                            <option value="Comatose">Comatose</option>
                        </select>

                        @error('consciousness')
                            <div id="selectConsciousnessFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <!-- /. row -->

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="selectHydration" class="form-label font-weight-normal">Hydration *</label>
                        <select wire:model.lazy="hydration"
                            class="custom-select custom-select-sm {{ $errors->has('hydration') ? 'is-invalid':'' }}"
                            id="selectHydration"
                            aria-describedby="selectHydrationFeedback">
                            <option value="choose" selected>Choose...</option>
                            <option value="Normal">Normal</option>
                            <option value="0-5%">0-5%</option>
                            <option value="6-7%">6-7%</option>
                            <option value="8-9%">8-9%</option>
                            <option value="+10%">+10%</option>
                        </select>

                        @error('hydration')
                            <div id="selectHydrationFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="selectPain" class="form-label font-weight-normal">Pain *</label>
                        <select wire:model.lazy="pain"
                            class="custom-select custom-select-sm {{ $errors->has('pain') ? 'is-invalid':'' }}"
                            id="selectPain"
                            aria-describedby="selectPainFeedback">
                            <option value="choose" selected>Choose...</option>
                            <option value="None">None</option>
                            <option value="Vocalization">Vocalization</option>
                            <option value="Changes in behavior">Changes in behavior</option>
                            <option value="Physical changes">Physical changes</option>
                        </select>

                        @error('pain')
                            <div id="selectPainFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="selectBodyCondition" class="form-label font-weight-normal">Body condition *</label>
                        <select wire:model.lazy="body_condition"
                            class="custom-select custom-select-sm {{ $errors->has('body_condition') ? 'is-invalid':'' }}"
                            id="selectBodyCondition"
                            aria-describedby="selectBodyConditionFeedback">
                            <option value="choose" selected>Choose...</option>
                            <option value="Too thin">Too thin</option>
                            <option value="Ideal">Ideal</option>
                            <option value="Too heavy">Too heavy</option>
                        </select>

                        @error('body_condition')
                            <div id="selectBodyConditionFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <!-- /. row -->

            {{--     <div class="form-row" wire:ignore>
                    <div class="form-group col-md-12" style="color: black;">
                        {{-- <label for="textareaProblemStatement"class="form-label font-weight-normal" style="color:white;">Problem statement</label> --}}
            {{--                 <textarea wire:model.lazy="problem_statement"
                                class="form-control form-control-sm {{ $errors->has('problem_statement') ? 'is-invalid':'' }}"
                                id="textareaProblemStatement"
                                placeholder="e.g. Anamnesis, analysis by system"
                                aria-describedby="textareaProblemStatementFeedback"
                                rows="4">
                            </textarea>

                        @error('problem_statement')
                            <div id="textareaProblemStatementFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> --}}
                <!-- /. row -->



                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="textareaProblemStatement"class="form-label font-weight-normal">Problem statement *</label>

                            {{-- CKEDITOR VISIBLE: es el ckeditor que se mostrará al usuario. El texto que
                                el usuario escriba aqué se deberá sincronizar con el TEXTAREA OCULTO a través del
                                script para crear, personalizar, etc., el CKEDITOR.
                            --}}
                            <div wire:ignore wire:key="myId" style="color:black;">
                                <textarea
                                    id="ckeditor"
                                    placeholder="e.g. Anamnesis, observations (análisis por sitema), problem list, master list, diagnostic plan, etc.">
                                </textarea>
                            </div>

                            {{-- TEXTAREA OCULTO: una vez que el texto escrito en el CKEDITOR está sincronizado con este TEXTAREA,
                                esta información se debe enviar al método UPDATE o STORE según corresponda para que en dichas funciones el
                                valor se le asigne al attibuto o propiedad $problem_statement
                            --}}
                            <textarea id="textareaProblemStatement" {{-- wire:model="problem_statement"  --}}hidden="true">
                            </textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputDiagnosis" class="form-label font-weight-normal">Diagnosis *</label>
                            <input wire:model.lazy="diagnosis"
                                type="text"
                                class="form-control form-control-sm {{ $errors->has('diagnosis') ? 'is-invalid':'' }}"
                                id="inputDiagnosis"
                                placeholder="e.g. Pyometra"
                                aria-describedby="inputDiagnosisFeedback">

                            @error('diagnosis')
                                <div id="inputDiagnosisFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="selectPrognosis" class="form-label font-weight-normal">Prognosis *</label>
                            <select wire:model.lazy="prognosis"
                                class="custom-select custom-select-sm {{ $errors->has('prognosis') ? 'is-invalid':'' }}"
                                id="selectPrognosis"
                                aria-describedby="selectPrognosisFeedback">
                                <option value="choose">Choose...</option>
                                <option selected value="Pending">Pending</option>
                                <option value="Good">Good</option>
                                <option value="Fair">Fair</option>
                                <option value="Guarded">Guarded</option>
                                <option value="Grave">Grave</option>
                                <option value="Poor">Poor</option>

                            </select>

                            @error('prognosis')
                                <div id="selectPrognosisFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="textareaTreatmentPlan"class="form-label font-weight-normal">Treatment plan</label>
                                <textarea wire:model.lazy="treatment_plan"
                                    class="form-control form-control-sm {{ $errors->has('treatment_plan') ? 'is-invalid':'' }}"
                                    id="textareaTreatmentPlan"
                                    placeholder="e.g. (1) Hospitalization, (2) Surgery, (3) medications, (4) medical progress exams."
                                    aria-describedby="textareaTreatmentPlanFeedback"
                                    rows="1">
                                </textarea>

                            @error('treatment_plan')
                                <div id="textareaTreatmentPlanFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="selectConsultStatus" class="form-label font-weight-normal">Consult status *</label>
                            <select wire:model.lazy="consult_status"
                                class="custom-select custom-select-sm {{ $errors->has('consult_status') ? 'is-invalid':'' }}"
                                id="selectConsultStatus"
                                aria-describedby="selectConsultStatusFeedback">
                                <option value="choose" selected>Choose...</option>
                                <option value="Lab pending tests">Lab pending</option>
                                <option value="Radiology pending tests">Radiology pending tests</option>
                                <option value="Closed">Closed</option>
                            </select>

                            @error('consult_status')
                                <div id="selectConsultStatusFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn bg-gradient-danger" data-dismiss="modal">
                        Close
                    </button>

                    @if($selected_id > 0)
                        <button type="button" wire:click.prevent="update(document.querySelector('#textareaProblemStatement').value)" class="btn bg-gradient-primary">Save changes</button>
                    @else
                        <button type="button" wire:click.prevent="store(document.querySelector('#textareaProblemStatement').value)" class="btn bg-gradient-primary">Save</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

</form>