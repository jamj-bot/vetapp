<form autocomplete="off" wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
	@include('common.modal-header')

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputDOB" class="form-label font-weight-normal">DOB *</label>
				<input wire:model.lazy="dob"
					type="date"
					class="form-control form-control-sm {{ $errors->has('dob') ? 'is-invalid':'' }}"
					id="inputDOB"
					placeholder="DOB"
					aria-describedby="inputDOBFeedback">

				@error('dob')
					<div id="inputDOBFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="selectSex" class="form-label font-weight-normal">Sex *</label>
				<select wire:model.lazy="sex"
					class="custom-select custom-select-sm {{ $errors->has('sex') ? 'is-invalid':'' }}"
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
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="selectNeutered" class="form-label font-weight-normal">Neutered *</label>
				<select wire:model.lazy="neutered"
					class="custom-select custom-select-sm {{ $errors->has('neutered') ? 'is-invalid':''}}"
					id="selectNeutered"
					aria-describedby="selectNeuteredFeedback">

						<option value="choose" selected>Choose...</option>
						<option value="Unknown">Unknown</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
				</select>

				@error('neutered')
					<div id="selectNeuteredFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>
		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="selectSpecies" class="form-label font-weight-normal">Species *</label>
				<select wire:model.lazy="species_id"
					class="custom-select custom-select-sm {{ $errors->has('species_id') ? 'is-invalid':'' }}"
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
				@enderror
			</div>

			<div class="form-group col-md-4">
				<label for="inputZootechnicalFunction" class="form-label font-weight-normal">Zootechnical Function</label>
				<input wire:model.lazy="zootechnical_function"
					type="text"
					class="form-control form-control-sm {{ $errors->has('breed') ? 'is-invalid':'' }}"
					id="inputZootechnicalFunction"
					placeholder="e.g. Beef Cattle"
					aria-describedby="inputZootechnicalFunctionFeedback">

				@error('zootechnical_function')
					<div id="inputZootechnicalFunctionFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

			<div class="form-group col-md-4">
				<label for="inputBreed" class="form-label font-weight-normal">Breed</label>
				<input wire:model.lazy="breed"
					type="text"
					class="form-control form-control-sm {{ $errors->has('breed') ? 'is-invalid':'' }}"
					id="inputBreed"
					placeholder="e.g. Weimaraner"
					aria-describedby="inputBreedFeedback">

				@error('breed')
					<div id="inputBreedFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>
		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputName" class="form-label font-weight-normal">Name *</label>
				<input wire:model.lazy="name"
					type="text"
					class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid':'' }}"
					id="inputName"
					placeholder="e.g. Firulais or 2074247899"
					aria-describedby="inputNameFeedback">

				@error('name')
					<div id="inputNameFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror

			</div>
			<div class="form-group col-md-6">
				<label for="inputCode" class="form-label font-weight-normal">Code *</label>
				<input wire:model.lazy="code"
					type="text"
					class="form-control form-control-sm {{ $errors->has('code') ? 'is-invalid':'' }}"
					id="inputCode"
					placeholder="e.g. 2074247899"
					aria-describedby="inputCodeFeedback">

			   @error('code')
					<div id="inputCodeFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror

			</div>
		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="textareaDiseases" class="form-label font-weight-normal">Diseases</label>
				<textarea wire:model.lazy="diseases"
				class="form-control form-control-sm {{ $errors->has('diseases') ? 'is-invalid':'' }}"
				id="textareaDiseases"
				placeholder="e.g. Idiopathic epilepsy, diabetes."
				aria-describedby="textareaDiseasesFeedback">
				</textarea>

				@error('diseases')
					<div id="textareaDiseasesFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

			<div class="form-group col-md-6">
				<label for="textareaAllergies"class="form-label font-weight-normal">Allergies</label>
					<textarea wire:model.lazy="allergies"
					class="form-control form-control-sm {{ $errors->has('allergies') ? 'is-invalid':'' }}"
					id="textareaAllergies"
					placeholder="e.g. Penicillin and derivatives, bee sting."
					aria-describedby="textareaAllergiesFeedback">
					</textarea>

				@error('allergies')
					<div id="textareaAllergiesFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>
		</div>
		<!-- /. row -->


		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="selectStatus" class="form-label font-weight-normal">Status *</label>
	   			<select wire:model.lazy="status"
					class="custom-select custom-select-sm {{ $errors->has('status') ? 'is-invalid':'' }}"
					id="selectStatus"
					aria-describedby="selectStatusFeedback">
						<option value="choose" selected>Choose...</option>
						<option value="Alive">Alive</option>
						<option value="Dead">Dead</option>
				</select>

	{{--   <div class="custom-control custom-radio">
	    <input type="radio" class="custom-control-input" id="customControlValidation2" name="radio-stacked" required checked="">
	    <label class="custom-control-label" for="customControlValidation2">Alive</label>
	  </div>
	  <div class="custom-control custom-radio mb-3">
	    <input type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked" required>
	    <label class="custom-control-label" for="customControlValidation3">Dead</label>
	    <div class="invalid-feedback">More example invalid feedback text</div>
	  </div> --}}

				@error('status')
					<div id="selectStatusFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror

			</div>
		</div>
		<!-- /. row -->

	@include('common.modal-footer')
</form>