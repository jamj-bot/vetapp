<form wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
	@include('common.modal-header')

		<div class="form-row">
			<div class="form-group col-md-12">
				<label class="form-label font-weight-normal">Target species *</label><br>
				@foreach($speciesList as  $speciesItem)
					<div class="form-check form-check-inline">
			  			<input class="form-check-input"
			  				type="checkbox"
			  				id="inlineCheckbox{{$speciesItem->id}}"
			  				{{-- wire:model="selected_species.{{ $speciesItem->id }}" --}}
			  				wire:model.defer="selected_species"
			  				value="{{$speciesItem->id}}"
			  				{{-- $speciesItem->checked == 1 ? 'checked' : ''--}}>
			  			<label class="form-check-label" for="inlineCheckbox{{$speciesItem->id}}">{{ $speciesItem->name }}</label>
					</div>
				@endforeach
			</div>
		</div>

		<div class="form-row">
{{-- 			<div class="form-group col-md-3">
				<label for="inputTargetSpecies" class="form-label font-weight-normal">Target species *</label>
				<input wire:model.lazy="target_species"
					type="text"
					class="form-control form-control-sm{{ $errors->has('target_species') ? 'is-invalid':'' }}"
					id="inputTargetSpecies"
					placeholder="e.g. Cattle"
					aria-describedby="inputTargetSpeciesFeedback">

				@error('target_species')
					<div id="inputTargetSpeciesFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div> --}}

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

		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="textareaDescription"class="form-label font-weight-normal">Description</label>
				<textarea wire:model.lazy="description"
					class="form-control form-control-sm
					{{ $errors->has('description') ? 'is-invalid':'' }}
					{{ $errors->has('description') == false && $this->description != null ? 'is-valid border-success':'' }}"
					id="textareaDescription"
					placeholder="e.g. For the active immunisation of cattle in order to induce..."
					aria-describedby="textareaDescriptionFeedback">
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

		<div class="form-row">
{{-- 			<div class="form-group col-md-8">
				<label for="inputAdministration" class="form-label font-weight-normal">Administration *</label>
				<input wire:model.lazy="administration"
					type="text"
					class="form-control form-control-sm {{ $errors->has('administration') ? 'is-invalid':'' }}"
					id="inputAdministration"
					placeholder="e.g. Subcutaneous (SC) or intramuscular (IM)"
					aria-describedby="inputAdministrationFeedback">

				@error('administration')
					<div id="inputAdministrationFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div> --}}
			<div class="form-group col-md-8">
				<label for="textareaAdministration"class="form-label font-weight-normal">Administration *</label>
					<textarea wire:model.lazy="administration"
						class="form-control form-control-sm
						{{ $errors->has('administration') ? 'is-invalid':'' }}
						{{ $errors->has('administration') == false && $this->administration != null ? 'is-valid border-success':'' }}"
						id="textareaAdministration"
						placeholder="e.g. Subcutaneous (SC) or intramuscular (IM)"
						aria-describedby="textareaAdministrationFeedback"
						rows="1">
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
					aria-describedby="inputDosageFeedback">

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
{{-- 			<div class="form-group col-md-8">
				<label for="inputPrimaryVaccination" class="form-label font-weight-normal">Primary vaccination *</label>
				<input wire:model.lazy="primary_vaccination"
					type="text"
					class="form-control form-control-sm {{ $errors->has('primary_vaccination') ? 'is-invalid':'' }}"
					id="inputPrimaryVaccination"
					placeholder="e.g. At 8 to 12 weeks of age"
					aria-describedby="inputPrimaryVaccinationFeedback">

				@error('primary_vaccination')
					<div id="inputPrimaryVaccinationFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div> --}}
			<div class="form-group col-md-8">
				<label for="textareaVaccinationSchedule"class="form-label font-weight-normal">Vaccination schedule *</label>
					<textarea wire:model.lazy="vaccination_schedule"
						class="form-control form-control-sm
						{{ $errors->has('vaccination_schedule') ? 'is-invalid':'' }}
						{{ $errors->has('vaccination_schedule') == false && $this->vaccination_schedule != null ? 'is-valid border-success':'' }}"
						id="textareaVaccinationSchedule"
						placeholder="e.g. At 3 months of age"
						aria-describedby="textareaVaccinationScheduleFeedback"
						rows="1">
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
				<input wire:model.lazy="primary_doses"
					type="number"
					class="form-control form-control-sm
					{{ $errors->has('primary_doses') ? 'is-invalid':'' }}
					{{ $errors->has('primary_doses') == false && $this->primary_doses != null ? 'is-valid border-success':'' }}"
					id="inputPrimaryDoses"
					placeholder="e.g. 2"
					aria-describedby="inputPrimaryDosesFeedback">

				@error('primary_doses')
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
{{-- 			<div class="form-group col-md-8">
				<label for="inputRevaccinationInterval" class="form-label font-weight-normal">Revaccination interval *</label>
				<input wire:model.lazy="revaccination_interval"
					type="text"
					class="form-control form-control-sm {{ $errors->has('revaccination_interval') ? 'is-invalid':'' }}"
					id="inputRevaccinationInterval"
					placeholder="e.g. Annual"
					aria-describedby="inputRevaccinationIntervalFeedback">

				@error('revaccination_interval')
					<div id="inputRevaccinationIntervalFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>
 --}}
			<div class="form-group col-md-8">
				<label for="textareaRevaccinationSchedule"class="form-label font-weight-normal">Revaccination schedule *</label>
					<textarea wire:model.lazy="revaccination_schedule"
						class="form-control form-control-sm
						{{ $errors->has('revaccination_schedule') ? 'is-invalid':'' }}
						{{ $errors->has('revaccination_schedule') == false && $this->revaccination_schedule != null ? 'is-valid border-success':'' }}"
						id="textareaRevaccinationSchedule"
						placeholder="e.g. Annual"
						aria-describedby="textareaRevaccinationScheduleFeedback"
						rows="1">
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
					aria-describedby="inputRevaccinationDosesFeedback">

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

	@include('common.modal-footer')
</form>
