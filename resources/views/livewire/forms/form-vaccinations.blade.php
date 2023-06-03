<form autocomplete="off" wire:submit.prevent="submit">
	@include('common.modal-header')

		<div class="form-row">
			<div class="form-group col-md-3">
				<label for="selectVaccine" class="form-label font-weight-normal">Vaccine *</label>
				<select wire:model.lazy="vaccine_id"
					class="custom-select custom-select-sm
					{{ $errors->has('vaccine_id') ? 'is-invalid':'' }}
					{{ $errors->has('vaccine_id') == false && $this->vaccine_id != 0 ? 'is-valid border-success':'' }}"
					id="selectVaccine"
					aria-describedby="selectVaccineFeedback">
					<option value="choose" selected>Choose...</option>
					@forelse($vaccines as $vaccine)
						<option value="{{ $vaccine->id }}">
							{{ $vaccine->name }} by {{ $vaccine->manufacturer }}
						</option>
					@empty
						<option value="choose" disabled> Empty </option>
					@endforelse
				</select>

				@error('vaccine_id')
					<div id="selectVaccineFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="selectVaccineFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>


			<div class="form-group col-md-3">
				<label for="selectType" class="form-label font-weight-normal">Type *</label>
				<select wire:model.lazy="type"
					class="custom-select custom-select-sm
					{{ $errors->has('type') ? 'is-invalid':'' }}
					{{ $errors->has('type') == false && $this->type != 'choose' ? 'is-valid border-success':'' }}"
					id="selectType"
					aria-describedby="selectTypeFeedback"
					{{ $vaccine_id == 0 ? 'disabled' : '' }}>

					<option selected value="choose">Choose...</option>
					<option value="Vaccination">Vaccination</option>
					<option value="Revaccination">Revaccination</option>
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
			</div>

			<div class="form-group col-6 col-md-3">
				<label for="inputDoseNumber" class="form-label font-weight-normal">Dose *</label>
				<input wire:model.lazy="dose_number"
					type="number"
					class="form-control form-control-sm
					{{ $errors->has('dose_number') == false && $this->dose_number != null ? 'is-valid border-success':'' }}"
					id="inputDoseNumber"
					placeholder="1"
					aria-describedby="inputDoseNumberFeedback">

				@error('dose_number')
					<div id="inputDoseNumberFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputDoseNumberFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>

			<div class="form-group col-6 col-md-3">
				<label for="inputDosesRequired" class="form-label font-weight-normal">Doses required *</label>
				<input wire:model.lazy="doses_required"
					type="number"
					class="form-control form-control-sm
					{{ $errors->has('doses_required') ? 'is-invalid':'' }}
					{{ $errors->has('doses_required') == false && $this->doses_required != null ? 'is-valid border-success':'' }}"
					id="inputDosesRequired"
					placeholder="{{number_format($this->suggested_doses)}}"
					aria-describedby="inputDosesRequiredFeedback">

				@error('doses_required')
					<div id="inputDosesRequiredFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputDosesRequiredFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>

		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputDone" class="form-label font-weight-normal">Done *</label>
				<input wire:model.lazy="done"
					type="date"
					class="form-control form-control-sm flatpickr
					{{ $errors->has('done') ? 'is-invalid':'' }}
					{{ $errors->has('done') == false && $this->done != null ? 'is-valid border-success':'' }}"
					id="inputDone"
					placeholder="Select date"
					aria-describedby="inputDoneFeedback">

				@error('done')
					<div id="inputDoneFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputDoneFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>

			<div class="form-group col-md-2">
				<label for="selectApplied" class="form-label font-weight-normal">Applied *</label>
				<select wire:model.lazy="applied"
					class="custom-select custom-select-sm
					{{ $errors->has('applied') ? 'is-invalid':'' }}
					{{ $errors->has('applied') == false && $this->applied != null ? 'is-valid border-success':'' }}"
					id="selectApplied"
					aria-describedby="selectAppliedFeedback">
					<option value="null">Choose...</option>
					<option value="1">Yes</option>
					<option selected value="0">No</option>

				</select>

				@error('applied')
					<div id="selectAppliedFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="selectAppliedFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>

			{{-- @if($this->applied == 1) --}}
				<div class="form-group col-md-4">
					<label for="inputBatchNumber" class="form-label font-weight-normal">Batch Number {{ $this->applied == 1 ? '*':'' }}</label>
					<input wire:model.lazy="batch_number"
						type="text"
						class="form-control form-control-sm
						{{ $errors->has('batch_number') ? 'is-invalid':'' }}
						{{ $errors->has('batch_number') == false && $this->batch_number != null ? 'is-valid border-success':'' }}"
						id="inputBatchNumber"
						placeholder="e.g. 123-MP-1L2O"
						aria-describedby="inputBatchNumberFeedback">

					@error('batch_number')
						<div id="inputBatchNumberFeedback" class="invalid-feedback">
							{{ $message }}
						</div>
	                @else
	                    <div id="inputBatchNumberFeedback" class="valid-feedback">
	                        Looks good!
	                    </div>
					@enderror
				</div>
			{{-- @endif --}}

		</div>
		<!-- /. row -->

		<div class="form-row">
		</div>
		<!-- /. row -->

	@include('common.modal-footer')
</form>

