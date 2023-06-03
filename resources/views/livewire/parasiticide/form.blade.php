<form autocomplete="off" wire:submit.prevent="submit">
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

			<div class="form-group col-md-4">
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

			<div class="form-group col-md-4">
				<label for="inputType" class="form-label font-weight-normal">Type *</label>

		        <select wire:model.lazy="type"
                    class="custom-select custom-select-sm
                    {{ $errors->has('type') ? 'is-invalid':'' }}
                    {{ $errors->has('type') == false && $this->type != 'choose' ? 'is-valid border-success':'' }}"
                    id="type"
                    aria-describedby="selectTypeFeedback">
                    <option value="choose" selected>Choose...</option>
                    <option value="Internal">Internal</option>
                    <option value="External">External</option>
                    <option value="Internal and external">Internal and external</option>
                </select>

                @error('type')
                    <div id="selectTypeFeedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @else
                    <div id="selectTypeFeedback" class="valid-feedback">
                        Looks good!
                    </div>
                @enderror

{{-- 				<input wire:model.lazy="type"
					type="text"
					class="form-control form-control-sm {{ $errors->has('type') ? 'is-invalid':'' }}"
					id="inputType"
					placeholder="e.g. Inactivated cells"
					aria-describedby="inputTypeFeedback">

				@error('type')
					<div id="inputTypeFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror --}}
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
				<label for="inputDose" class="form-label font-weight-normal">Dose *</label>
				<input wire:model.lazy="dose"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('dose') ? 'is-invalid':'' }}
					{{ $errors->has('dose') == false && $this->dose != null ? 'is-valid border-success':'' }}"
					id="inputDose"
					placeholder="e.g. 2 ml"
					aria-describedby="inputDoseFeedback">

				@error('dose')
					<div id="inputDoseFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="textareaAdministrationFeedback" class="valid-feedback">
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
				<label for="textareaPrimaryApplication"class="form-label font-weight-normal">Primary application *</label>
					<textarea wire:model.lazy="primary_application"
						class="form-control form-control-sm
						{{ $errors->has('primary_application') ? 'is-invalid':'' }}
						{{ $errors->has('primary_application') == false && $this->primary_application != null ? 'is-valid border-success':'' }}"
						id="textareaPrimaryApplication"
						placeholder="e.g. At 3 months of age"
						aria-describedby="textareaPrimaryApplicationFeedback"
						rows="1">
					</textarea>

				@error('primary_application')
					<div id="textareaPrimaryApplicationFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="textareaPrimaryApplicationFeedback" class="valid-feedback">
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
				<label for="textareaReapplicationInterval"class="form-label font-weight-normal">Reapplication interval *</label>
					<textarea wire:model.lazy="reapplication_interval"
						class="form-control form-control-sm
						{{ $errors->has('reapplication_interval') ? 'is-invalid':'' }}
						{{ $errors->has('reapplication_interval') == false && $this->reapplication_interval != null ? 'is-valid border-success':'' }}"
						id="textareaReapplicationInterval"
						placeholder="e.g. Every year"
						aria-describedby="textareaReapplicationIntervalFeedback"
						rows="1">
					</textarea>

				@error('reapplication_interval')
					<div id="textareaReapplicationIntervalFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="textareaReapplicationIntervalFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>

			<div class="form-group col-md-4">
				<label for="inputReapplicationDoses" class="form-label font-weight-normal">Reapplication doses *</label>
				<input wire:model.lazy="reapplication_doses"
					type="number"
					class="form-control form-control-sm
					{{ $errors->has('reapplication_doses') ? 'is-invalid':'' }}
					{{ $errors->has('reapplication_doses') == false && $this->reapplication_doses != null ? 'is-valid border-success':'' }}"
					id="inputReapplicationDoses"
					placeholder="e.g. 1"
					aria-describedby="inputReapplicationFeedback">

				@error('reapplication_doses')
					<div id="inputReapplicationFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputReapplicationFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<label class="form-label font-weight-normal">Target species *</label><br>
				@foreach($speciesList as  $speciesItem)
					<div class="{{-- form-check form-check-inline  --}}icheck-greensea {{-- icheck-inline --}}">
			  			<input class="form-check-input"
			  				type="checkbox"
			  				checked
			  				id="inlineCheckbox{{$speciesItem->id}}"
			  				{{-- wire:model="selected_species.{{ $speciesItem->id }}" --}}
			  				wire:model.defer="selected_species"
			  				value="{{$speciesItem->id}}"
			  				{{-- $speciesItem->checked == 1 ? 'checked' : ''--}}>
			  			<label class="form-check-label" for="inlineCheckbox{{$speciesItem->id}}">
			  				{{ $speciesItem->name }} / <span class="text-muted font-italic">{{ $speciesItem->scientific_name}}</span>
			  			</label>
					</div>
				@endforeach

				@error('selected_species')
					<div class="text-xs text-danger">
						{{ $message }}
					</div>
				@enderror
			</div>
		</div>
	@include('common.modal-footer')
</form>
