<form autocomplete="off" wire:submit.prevent="submit">

			@include('common.modal-header')

				<!-- Card body -->
					 <!-- Steps -->
					<div class="container">
					  	<div class="row d-flex flex-wrap justify-content-around align-self-center text-center">
					  		@for($i = 1; $i < 5; $i++ )
						  		<div class="col-3">
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

					@if($this->currentStep === 1)
						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="inputName" class="form-label font-weight-normal">Name *</label>
								<input wire:model.lazy="name"
									type="text"
									class="form-control form-control-sm
									{{ $errors->has('name') ? 'is-invalid':'' }}
									{{ $errors->has('name') == false && $this->name != null ? 'is-valid border-success':'' }}"
									id="inputName"
									placeholder="e.g. Bovilis Bovivac®"
									aria-describedby="inputNameFeedback">

								@error('name')
									<div id="inputNameFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="inputNameFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>

							<div class="form-group col-md-3">
								<label for="inputManufacturer" class="form-label font-weight-normal">Manufacturer *</label>
								<input wire:model.lazy="manufacturer"
									type="text"
									class="form-control form-control-sm
									{{ $errors->has('manufacturer') ? 'is-invalid':'' }}
									{{ $errors->has('manufacturer') == false && $this->manufacturer != null ? 'is-valid border-success':'' }}"
									id="inputManufacturer"
									placeholder="e.g. Virbac"
									aria-describedby="inputManufacturerFeedback">

								@error('manufacturer')
									<div id="inputManufacturerFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="inputManufacturerFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>

							<div class="form-group col-md-3">
								<label for="inputType" class="form-label font-weight-normal">Type *</label>
								<input wire:model.lazy="type"
									type="text"
									class="form-control form-control-sm
									{{ $errors->has('type') ? 'is-invalid':'' }}
									{{ $errors->has('type') == false && $this->type != null ? 'is-valid border-success':'' }}"
									id="inputType"
									placeholder="e.g. Inactivated cells"
									aria-describedby="inputTypeFeedback">

								@error('type')
									<div id="inputTypeFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="inputTypeFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>

							<div class="form-group col-md-3">
								<label for="selectStatus" class="form-label font-weight-normal">Status *</label>
								<select wire:model.lazy="status"
									class="custom-select custom-select-sm
									{{ $errors->has('status') ? 'is-invalid':'' }}
									{{ $errors->has('status') == false && $this->status != 'choose' ? 'is-valid border-success':'' }}"
									id="selectStatus"
									aria-describedby="selectStatusFeedback">

									<option value="choose" selected>Choose...</option>
									<option value="Required">Required</option>
									<option value="Recommended">Recommended</option>
									<option value="Optional">Optional</option>
								</select>

								@error('status')
									<div id="selectStatusFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="selectStatusFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>
						</div>

                        <div class="form-row col-md-12">
                            <label for="textareaDisease"class="form-label font-weight-normal">Diseases *</label>
                                <textarea wire:model.lazy="disease"
                                    class="form-control form-control-sm
                                    {{ $errors->has('disease') ? 'is-invalid':'' }}
                                    {{ $errors->has('disease') == false && $this->disease != null ? 'is-valid border-success':'' }}"
                                    id="textareaDisease"
                                    placeholder="e.g. Pyometra; Necrosis and fatty degeneration; Difuse, severe, liver."
                                    aria-describedby="textareaDiseaseFeedback"
                                    rows="1">
                                </textarea>

                            @error('disease')
                                <div id="textareaDiseaseFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @else
                                <div id="textareaDiseaseFeedback" class="valid-feedback">
                                    Looks good!
                                </div>
                            @enderror
                        </div>

						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="textareaDescription"class="form-label font-weight-normal">Description *</label>
								<textarea wire:model.lazy="description"
									class="form-control form-control-sm
									{{ $errors->has('description') ? 'is-invalid':'' }}
									{{ $errors->has('description') == false && $this->description != null ? 'is-valid border-success':'' }}"
									id="textareaDescription"
									placeholder="e.g. For the active immunisation of cattle in order to induce..."
									aria-describedby="textareaDescriptionFeedback"
									rows="2">
								</textarea>

								@error('description')
									<div id="textareaDescriptionFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="textareaDescriptionFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>
						</div>
					@endif

					@if($this->currentStep === 2)
						<div class="form-row">
							<div class="form-group col-md-12">
								<label class="form-label font-weight-normal">Target species *</label><br>
								<div class="row">
									@foreach($speciesList as $key => $speciesItem)
										<div class="col-sm-12 col-md-6">
											<div class="{{-- form-check form-check-inline --}} icheck-greensea">
												<input class="form-check-input"
													type="checkbox"
													id="inlineCheckbox{{$speciesItem->id}}"
													wire:model.defer="selected_species"
													value="{{$speciesItem->id}}"
													aria-describedby="inputSelectedSpeciesFeedback"
													{{-- {{in_array($speciesItem->id,$this->selected_species) ? 'checked':''}} --}}>
												<label class="form-check-label" for="inlineCheckbox{{$speciesItem->id}}">
													{{ $speciesItem->name }} /<span class="text-muted font-italic">{{ $speciesItem->scientific_name }}</span>
												</label>
											</div>
										</div>
									@endforeach
								</div>

								@error('selected_species')
									<div class="text-xs text-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
					@endif

					@if($this->currentStep === 3 || $this->currentStep === 4)

{{-- 						<div class="form-row d-flex justify-content-end mr-1">
							<div class="lead">{{$this->currentStep === 4 ? 'Form completed' : '' }}</div>
						</div> --}}
						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="textareaAdministration"class="form-label font-weight-normal">Administration *</label>
									<textarea wire:model.lazy="administration"
										class="form-control form-control-sm
										{{ $errors->has('administration') ? 'is-invalid':'' }}
										{{ $errors->has('administration') == false && $this->administration != null ? 'is-valid border-success':'' }}"
										id="textareaAdministration"
										placeholder="e.g. Subcutaneous (SC) or intramuscular (IM)"
										aria-describedby="textareaAdministrationFeedback"
										rows="1"
										{{ $this->currentStep === 4 ? 'readonly' : '' }}>
									</textarea>

								@error('administration')
									<div id="textareaAdministrationFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="textareaAdministrationFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>

							<div class="form-group col-md-4">
								<label for="inputDosage" class="form-label font-weight-normal">Dosage *</label>
								<input wire:model.lazy="dosage"
									type="text"
									class="form-control form-control-sm
									{{ $errors->has('dosage') ? 'is-invalid':'' }}
									{{ $errors->has('dosage') == false && $this->dosage != null ? 'is-valid border-success':'' }}"
									id="inputDosage"
									placeholder="e.g. 2 ml"
									aria-describedby="inputDosageFeedback"
									{{ $this->currentStep === 4 ? 'readonly' : '' }}>

								@error('dosage')
									<div id="inputDosageFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="inputDosageFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="textareaVaccinationSchedule"class="form-label font-weight-normal">Vaccination schedule *</label>
									<textarea wire:model.lazy="vaccination_schedule"
										class="form-control form-control-sm
										{{ $errors->has('vaccination_schedule') ? 'is-invalid':'' }}
										{{ $errors->has('vaccination_schedule') == false && $this->vaccination_schedule != null ? 'is-valid border-success':'' }}"
										id="textareaVaccinationSchedule"
										placeholder="e.g. At 3 months of age"
										aria-describedby="textareaVaccinationScheduleFeedback"
										rows="1"
										{{ $this->currentStep === 4 ? 'readonly' : '' }}>
									</textarea>

								@error('vaccination_schedule')
									<div id="textareaVaccinationScheduleFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="textareaVaccinationScheduleFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>

							<div class="form-group col-md-4">
								<label for="inputPrimaryDoses" class="form-label font-weight-normal">Primary doses *</label>
								<input wire:model.lazy="vaccination_doses"
									type="number"
									class="form-control form-control-sm
									{{ $errors->has('vaccination_doses') ? 'is-invalid':'' }}
									{{ $errors->has('vaccination_doses') == false && $this->vaccination_doses != null ? 'is-valid border-success':'' }}"
									id="inputPrimaryDoses"
									placeholder="e.g. 2"
									aria-describedby="inputPrimaryDosesFeedback"
									{{ $this->currentStep === 4 ? 'readonly' : '' }}>

								@error('vaccination_doses')
									<div id="inputPrimaryDosesFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="inputPrimaryDosesFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="textareaRevaccinationSchedule"class="form-label font-weight-normal">Revaccination schedule *</label>
									<textarea wire:model.lazy="revaccination_schedule"
										class="form-control form-control-sm
										{{ $errors->has('revaccination_schedule') ? 'is-invalid':'' }}
										{{ $errors->has('revaccination_schedule') == false && $this->revaccination_schedule != null ? 'is-valid border-success':'' }}"
										id="textareaRevaccinationSchedule"
										placeholder="e.g. Annual"
										aria-describedby="textareaRevaccinationScheduleFeedback"
										rows="1"
										{{ $this->currentStep === 4 ? 'readonly' : '' }}>
									</textarea>

								@error('revaccination_schedule')
									<div id="textareaRevaccinationScheduleFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="textareaRevaccinationScheduleFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>

							<div class="form-group col-md-4">
								<label for="inputRevaccinationDoses" class="form-label font-weight-normal">Revaccination doses *</label>
								<input wire:model.lazy="revaccination_doses"
									type="number"
									class="form-control form-control-sm
									{{ $errors->has('revaccination_doses') ? 'is-invalid':'' }}
									{{ $errors->has('revaccination_doses') == false && $this->revaccination_doses != null ? 'is-valid border-success':'' }}"
									id="inputRevaccinationDoses"
									placeholder="e.g. 1"
									aria-describedby="inputRevaccinationDosesFeedback"
									{{ $this->currentStep === 4 ? 'readonly' : '' }}>

								@error('revaccination_doses')
									<div id="inputRevaccinationDosesFeedback" class="invalid-feedback">
										{{ $message }}
									</div>
				                @else
				                    <div id="inputRevaccinationDosesFeedback" class="valid-feedback">
				                        Looks good!
				                    </div>
								@enderror
							</div>
						</div>
					@endif

	            </div>
	            {{-- ./ Body --}}

	            <div class="modal-footer">

	            	{{-- Loader --}}
                	<div wire:loading.class="overlay dark" wire:target="goToPreviousStep, goToNextStep, store, update">
                		<div class="" wire:loading wire:target="goToPreviousStep, goToNextStep, store, update">
                			<div class="d-flex justify-content-center"><span class="loader"></span></div>
                			@if($this->currentStep == $this->totalSteps)
                				<div class="text-xl lead font-weight-bold">{{ $this->selected_id ? 'Updating...' : 'Saving...'}}</div>
                			@endif
                		</div>
                	</div>

            		@if($this->currentStep === 1)
						<div></div>
					@endif

					@if($this->currentStep === 2 || $this->currentStep === 3 || $this->currentStep === 4)
						<button class="btn btn-light" type="button"
							wire:click.prevent="goToPreviousStep">
								<i class="fas fa-chevron-left text-xs"></i> Back
						</button>
					@endif

					@if($this->currentStep === 1 || $this->currentStep === 2 || $this->currentStep === 3)
						<button class="btn btn-light" type="button"
							wire:click.prevent="goToNextStep">
								Next <i class="fas fa-chevron-right text-xs"></i>
						</button>
					@endif

	            	@if($this->currentStep === 4)

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
	        </div>
	    </div>
	</div>
</form>


