<form autocomplete="off" wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
	@include('common.modal-header')

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="selectVaccine" class="form-label font-weight-normal">Vaccine *</label>
				<select wire:model.lazy="vaccine_id"
					class="custom-select custom-select-sm {{ $errors->has('vaccine_id') ? 'is-invalid':'' }}"
					id="selectVaccine"
					aria-describedby="selectVaccineFeedback">
					<option value="choose" selected>Choose...</option>
					@foreach($vaccines as $vaccine)
						<option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
					@endforeach
				</select>

				@error('vaccine_id')
					<div id="selectVaccineFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>


			<div class="form-group col-md-4">
				<label for="selectType" class="form-label font-weight-normal">Type *</label>
				<select wire:model.lazy="type"
					class="custom-select custom-select-sm {{ $errors->has('type') ? 'is-invalid':'' }}"
					id="selectType"
					aria-describedby="selectTypeFeedback">

					<option selected value="choose">Choose</option>
					<option value="Vaccination">Vaccination</option>
					<option value="Revaccination">Revaccination</option>
				</select>

				@error('type')
					<div id="selectTypeFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

			<div class="form-group col-md-4">
				<label for="inputBatchNumber" class="form-label font-weight-normal">Batch Number *</label>
				<input wire:model.lazy="batch_number"
					type="text"
					class="form-control form-control-sm {{ $errors->has('batch_number') ? 'is-invalid':'' }}"
					id="inputBatchNumber"
					placeholder="e.g. 000-MZ5-12O"
					aria-describedby="inputBatchNumberFeedback">

				@error('batch_number')
					<div id="inputBatchNumberFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

		</div>
		<!-- /. row -->

		<div class="form-row">

			<div class="form-group col-md-2">
				<label for="inputDoseNumber" class="form-label font-weight-normal">Dose *</label>
				<input wire:model.lazy="dose_number"
					type="number"
					class="form-control disabled form-control-sm {{ $errors->has('dose_number') ? 'is-invalid':'' }}"
					id="inputDoseNumber"
					placeholder="1"
					aria-describedby="inputDoseNumberFeedback">

				@error('dose_number')
					<div id="inputDoseNumberFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

			<div class="form-group col-md-2">
				<label for="inputDosesRequired" class="form-label font-weight-normal">Doses required *</label>
				<input wire:model.lazy="doses_required"
					type="number"
					class="form-control disabled form-control-sm {{ $errors->has('doses_required') ? 'is-invalid':'' }}"
					id="inputDosesRequired"
					placeholder="3"
					aria-describedby="inputDosesRequiredFeedback">

				@error('doses_required')
					<div id="inputDosesRequiredFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

{{-- 			<div class="form-group col-md-3">
				<label for="selectDoseNumber" class="form-label font-weight-normal">Dose number *</label>
				<select wire:model.lazy="dose_number"
					class="custom-select custom-select-sm {{ $errors->has('dose_number') ? 'is-invalid':'' }}"
					id="selectDoseNumber"
					aria-describedby="selectDoseNumberFeedback">

					<option selected value="choose">Choose</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>

				@error('dose_number')
					<div id="selectDoseNumberFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

			<div class="form-group col-md-3">
				<label for="selectDosesRequired" class="form-label font-weight-normal">Doses required *</label>
				<select wire:model.lazy="doses_required"
					class="custom-select custom-select-sm {{ $errors->has('doses_required') ? 'is-invalid':'' }}"
					id="selectDosesRequired"
					aria-describedby="selectDosesRequiredFeedback">

					<option selected value="choose">Choose</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>

				@error('doses_required')
					<div id="selectDosesRequiredFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div> --}}

			<div class="form-group col-md-6">
				<label for="inputDone" class="form-label font-weight-normal">Done</label>
				<input wire:model.lazy="done"
					type="date"
					class="form-control form-control-sm {{ $errors->has('done') ? 'is-invalid':'' }}"
					id="inputDone"
					placeholder="Done"
					aria-describedby="inputDoneFeedback">

				@error('done')
					<div id="inputDoneFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

			<div class="form-group col-md-2">
				<label for="selectApplied" class="form-label font-weight-normal">Applied *</label>
				<select wire:model.lazy="applied"
					class="custom-select custom-select-sm {{ $errors->has('applied') ? 'is-invalid':'' }}"
					id="selectApplied"
					aria-describedby="selectAppliedFeedback">

					<option value="1">Yes</option>
					<option selected value="0">No</option>

				</select>

				@error('applied')
					<div id="selectAppliedFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

{{-- 			@if($last_dose == 0)
				<div class="form-group col-md-6">
					<label for="inputNext" class="form-label font-weight-normal">Next</label>
					<input wire:model.lazy="next"
						type="date"
						class="form-control disabled form-control-sm {{ $errors->has('next') ? 'is-invalid':'' }}"
						id="inputNext"
						placeholder="Next"
						aria-describedby="inputNextFeedback">

					@error('next')
						<div id="inputNextFeedback" class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			@endif --}}
		</div>
		<!-- /. row -->

		{{-- @if($selected_id > 0) --}}
			<div class="form-row">
{{-- 	 			<div class="form-group col-md-12">
					<label for="selectApplied" class="form-label font-weight-normal">Applied</label>
					<select wire:model.lazy="applied"
						class="custom-select custom-select-sm {{ $errors->has('applied') ? 'is-invalid':'' }}"
						id="selectApplied"
						aria-describedby="selectAppliedFeedback">

						<option value="1">Yes</option>
						<option selected value="0">No</option>

					</select>

					@error('applied')
						<div id="selectAppliedFeedback" class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div> --}}
			</div>
			<!-- /. row -->
		{{-- @endif --}}

	@include('common.modal-footer')

</form>