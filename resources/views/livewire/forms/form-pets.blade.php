<form autocomplete="off" wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
	@include('common.modal-header')
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputName" class="form-label font-weight-normal">Name *</label>
				<input wire:model.lazy="name"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('name') ? 'is-invalid':'' }}
					{{ $errors->has('name') == false && $this->name != null ? 'is-valid border-success':'' }}"
					id="inputName"
					placeholder="e.g. Firulais or 2074247899"
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
			<div class="form-group col-md-4">
				<label for="inputCode" class="form-label font-weight-normal">Code *</label>
				<input wire:model.lazy="code"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('code') ? 'is-invalid':'' }}
					{{ $errors->has('code') == false && $this->code != null ? 'is-valid border-success':'' }}"
					id="inputCode"
					placeholder="e.g. 2074247899"
					aria-describedby="inputCodeFeedback">

			   @error('code')
					<div id="inputCodeFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputCodeFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="selectSpecies" class="form-label font-weight-normal">Species *</label>
				<select wire:model.lazy="species_id"
					class="custom-select custom-select-sm
					{{ $errors->has('species_id') ? 'is-invalid':'' }}
					{{ $errors->has('species_id') == false && $this->species_id != 'choose' ? 'is-valid border-success':'' }}"
					id="selectSpecies"
					aria-describedby="selectSpeciesFeedback">
					<option value="choose" selected>Choose...</option>
					@foreach($species as $specie)
						<option value="{{ $specie->id }}">{{ $specie->name }}</option>
					@endforeach
				</select>

				@error('species_id')
					<div id="selectSpeciesFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="selectSpeciesFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>

		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputDOB" class="form-label font-weight-normal">DOB *</label>
				<input wire:model.lazy="dob"
					type="date"
					class="form-control form-control-sm
					{{ $errors->has('dob') ? 'is-invalid':'' }}
					{{ $errors->has('dob') == false && $this->dob != null ? 'is-valid border-success':'' }}"
					id="inputDOB"
					placeholder="DOB"
					aria-describedby="inputDOBFeedback">

				@error('dob')
					<div id="inputDOBFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputDOBFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

			<div class="col-md-4">
				<label for="checkboxEstimated" class="form-label font-weight-normal">Estimated *</label>
				<div class="form-group clearfix">
					<div class="icheck-emerland d-inline">
						<input wire:model.lazy="estimated" type="radio" id="radioEstimated1" name="radioEstimated" value="1">
						<label for="radioEstimated1">
							Estimated
						</label>
					</div>
					<div class="icheck-pomegranate d-inline">
						<input wire:model.lazy="estimated" type="radio" id="radioEstimated2" name="radioEstimated" value="0">
						<label for="radioEstimated2">
							Not estimated
						</label>
					</div>
				</div>



{{-- 				<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
					<input type="checkbox"
						class="custom-control-input"
						id="checkboxEstimated"
						aria-describedby="checkboxEstimatedFeedback"
						wire:model.lazy="estimated"
						{{ {{ $estimated == 1 ? 'checked' : '' }}
						value="1">
					<label class="custom-control-label font-weight-normal" for="checkboxEstimated">
						{{ $estimated == 1 ? 'DOB is estimated' : 'DOB is not estimated' }}
					</label>
				</div> --}}

				@error('estimated')
					<div id="radioEstimatedFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="radioEstimatedFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

			<div class="form-group col-md-4">
				<label for="selectSex" class="form-label font-weight-normal">Sex *</label>
				<select wire:model.lazy="sex"
					class="custom-select custom-select-sm
					{{ $errors->has('sex') ? 'is-invalid':'' }}
					{{ $errors->has('sex') == false && $this->sex != 'choose' ? 'is-valid border-success':'' }}"
					id="selectSex"
					aria-describedby="selectSexFeedback">

					<option value="choose" selected>Choose...</option>
					<option value="Unknown">Unknown</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>

				</select>

				@error('sex')
					<div id="selectSexFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="selectSexFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>
		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputZootechnicalFunction" class="form-label font-weight-normal">Zootechnical Function</label>
				<input wire:model.lazy="zootechnical_function"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('zootechnical_function') ? 'is-invalid':'' }}
					{{ $errors->has('zootechnical_function') == false && $this->zootechnical_function != null ? 'is-valid border-success':'' }}"
					id="inputZootechnicalFunction"
					placeholder="e.g. Beef Cattle"
					aria-describedby="inputZootechnicalFunctionFeedback">

				@error('zootechnical_function')
					<div id="inputZootechnicalFunctionFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputZootechnicalFunctionFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

			<div class="form-group col-md-4">
				<label for="inputBreed" class="form-label font-weight-normal">Breed</label>
				<input wire:model.lazy="breed"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('breed') ? 'is-invalid':'' }}
					{{ $errors->has('breed') == false && $this->breed != null ? 'is-valid border-success':'' }}"
					id="inputBreed"
					placeholder="e.g. Weimaraner"
					aria-describedby="inputBreedFeedback">

				@error('breed')
					<div id="inputBreedFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputBreedFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

			<div class="form-group col-md-4">
				<label for="selectDesexed" class="form-label font-weight-normal">Desexed *</label>
				<select wire:model.lazy="desexed"
					class="custom-select custom-select-sm
					{{ $errors->has('desexed') ? 'is-invalid':''}}
					{{ $errors->has('desexed') == false && $this->desexed != 'choose' ? 'is-valid border-success':'' }}"
					id="selectDesexed"
					aria-describedby="selectDesexedFeedback">
						<option value="choose" selected>Choose...</option>
						<option value="Unknown">Unknown</option>
						<option value="Desexed" {{ $desexing_candidate == 0 ? 'disabled' : ''}} >Desexed</option>
						<option value="Not desexed">Not desexed</option>
				</select>

				@error('desexed')
					<div id="selectDesexedFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="selectDesexedFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>
		</div>
		<!-- /. row -->

		<div class="form-row" style="display: {{ $desexed == 'Desexed' ? 'none' : '' }};">
			<div class="form-group ml-2">
				<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
					<input type="checkbox"
						class="custom-control-input"
						id="checkboxDesexingCandidate"
						aria-describedby="selectDesexingCandidateFeedback"
						wire:model.lazy="desexing_candidate"
						{{ $desexing_candidate == 1 ? 'checked' : '' }}
						value="1">
					<label class="custom-control-label font-weight-normal" for="checkboxDesexingCandidate">
						Desexing candidate
					</label>
				</div>

				@error('desexing_candidate')
					<div id="selectDesexingCandidateFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="selectDesexingCandidateFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>
		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="textareaAlerts" class="form-label font-weight-normal">Alerts</label>
				<textarea wire:model.lazy="alerts"
					class="form-control form-control-sm
					{{ $errors->has('alerts') ? 'is-invalid':'' }}
					{{ $errors->has('alerts') == false && $this->alerts != null ? 'is-valid border-success':'' }}"
					id="textareaAlerts"
					placeholder="e.g. Aggressive, fearful, reactive to unexpected stimuli."
					aria-describedby="textareaAlertsFeedback">
				</textarea>

				@error('alerts')
					<div id="textareaAlertsFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="textareaAlertsFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

			<div class="form-group col-md-4">
				<label for="textareaDiseases" class="form-label font-weight-normal">Diseases</label>
				<textarea wire:model.lazy="diseases"
					class="form-control form-control-sm
					{{ $errors->has('diseases') ? 'is-invalid':'' }}
					{{ $errors->has('diseases') == false && $this->diseases != null ? 'is-valid border-success':'' }}"
					id="textareaDiseases"
					placeholder="e.g. Pre-existing conditions and past treatments: Idiopathic epilepsy, diabetes."
					aria-describedby="textareaDiseasesFeedback">
				</textarea>

				@error('diseases')
					<div id="textareaDiseasesFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="textareaDiseasesFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

			<div class="form-group col-md-4">
				<label for="textareaAllergies"class="form-label font-weight-normal">Allergies</label>
					<textarea wire:model.lazy="allergies"
					class="form-control form-control-sm
					{{ $errors->has('allergies') ? 'is-invalid':'' }}
					{{ $errors->has('allergies') == false && $this->allergies != null ? 'is-valid border-success':'' }}"
					id="textareaAllergies"
					placeholder="e.g. Penicillin and derivatives, bee sting."
					aria-describedby="textareaAllergiesFeedback">
					</textarea>

				@error('allergies')
					<div id="textareaAllergiesFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="textareaAllergiesFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>
		</div>
		<!-- /. row -->


		<div class="form-row d-flex justify-content-end">
			<div class="form-group col-md-4">
				<label for="selectStatus" class="form-label font-weight-normal">Status *</label>
	   			<select wire:model.lazy="status"
					class="custom-select custom-select-sm
					{{ $errors->has('status') ? 'is-invalid':'' }}
					{{ $errors->has('status') == false && $this->status != 'choose' ? 'is-valid border-success':'' }}"
					id="selectStatus"
					aria-describedby="selectStatusFeedback">
						<option value="choose" selected>Choose...</option>
						<option value="Alive">Alive / Active</option>
						<option value="Dead">Dead / Inactive</option>
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
		<!-- /. row -->

	@include('common.modal-footer')
</form>
