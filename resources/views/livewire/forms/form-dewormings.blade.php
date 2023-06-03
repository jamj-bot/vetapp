<form autocomplete="off" wire:submit.prevent="submit">
    @include('common.modal-header')

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="selectParasiticed" class="form-label font-weight-normal">Parasiticide *</label>
				<select wire:model.lazy="parasiticide_id"
					class="custom-select custom-select-sm
					{{ $errors->has('parasiticide_id') ? 'is-invalid':'' }}
					{{ $errors->has('parasiticide_id') == false && $this->parasiticide_id != 0 ? 'is-valid border-success':'' }}"
					id="selectParasiticed"
					aria-describedby="selectParasiticideFeedback">
					<option value= 0 selected> Choose...</option>
					@foreach($parasiticides as $parasiticide)
						<option value="{{ $parasiticide->id }}">{{ $parasiticide->name }}</option>
					@endforeach
				</select>

				@error('parasiticide_id')
					<div id="selectParasiticideFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="selectParasiticideFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>


			<div class="form-group col-md-4">
				<label for="selectType" class="form-label font-weight-normal">Type *</label>
				<select wire:model.lazy="type"
					class="custom-select custom-select-sm
					{{ $errors->has('type') ? 'is-invalid':'' }}
					{{ $errors->has('type') == false && $this->type != 'choose' ? 'is-valid border-success':'' }}"
					id="selectType"
					aria-describedby="selectTypeFeedback"
					{{ $parasiticide_id == null ? 'disabled' : ''}}>

					<option selected value="choose">Choose...</option>
					<option value="First application">First application</option>
					<option value="Reapplication">Reapplication</option>
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

			<div class="form-group col-md-4">
				<label for="inputDuration" class="form-label font-weight-normal">Duration *</label>
				<input wire:model.lazy="duration"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('duration') ? 'is-invalid':'' }}
					{{ $errors->has('duration') == false && $this->duration != null ? 'is-valid border-success':'' }}"
					id="inputDuration"
					placeholder="e.g. 6 months"
					aria-describedby="inputDurationFeedback">

				@error('duration')
					<div id="inputDurationFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputDurationFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>
		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputWithdrawalPeriod" class="form-label font-weight-normal">Withdrawal period</label>
				<input wire:model.lazy="withdrawal_period"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('withdrawal_period') ? 'is-invalid':'' }}
					{{ $errors->has('withdrawal_period') == false && $this->withdrawal_period != null ? 'is-valid border-success':'' }}"
					id="inputWithdrawalPeriod"
					placeholder="e.g. Milk: 49 days + 3 milkings"
					aria-describedby="inputWithdrawalPeriodFeedback">

				@error('withdrawal_period')
					<div id="inputWithdrawalPeriodFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputWithdrawalPeriodFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="inputDoseNumber" class="form-label font-weight-normal">Dose *</label>
				<input wire:model.lazy="dose_number"
					type="number"
					class="form-control form-control-sm
					{{ $errors->has('dose_number') ? 'is-invalid':'' }}
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

			<div class="form-group col-md-4">
				<label for="inputDosesRequired" class="form-label font-weight-normal">Doses required {{$this->suggested_dosage ? $this->suggested_dosage:'' }} *</label>
				<input wire:model.lazy="doses_required"
					type="number"
					class="form-control form-control-sm
					{{ $errors->has('doses_required') ? 'is-invalid':'' }}
					{{ $errors->has('doses_required') == false && $this->doses_required != null ? 'is-valid border-success':'' }}"
					id="inputDosesRequired"
					placeholder="3"
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

    @include('common.modal-footer')
</form>