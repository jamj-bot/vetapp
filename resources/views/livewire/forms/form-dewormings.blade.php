<form autocomplete="off" wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
<div wire:ignore.self class="modal fade" id="modalFormDewormings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <b>{{ $modalTitle }}</b> | {{ $selected_id > 0 ? 'Editing' : 'Creating' }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

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
							aria-describedby="inputDoseNumberFeedback"
							readonly disabled>

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
						<label for="inputDosesRequired" class="form-label font-weight-normal">Doses required *</label>
						<input wire:model.lazy="doses_required"
							type="number"
							class="form-control form-control-sm
							{{ $errors->has('doses_required') ? 'is-invalid':'' }}
							{{ $errors->has('doses_required') == false && $this->doses_required != null ? 'is-valid border-success':'' }}"
							id="inputDosesRequired"
							placeholder="3"
							aria-describedby="inputDosesRequiredFeedback"
							readonly disabled>

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

{{-- 					<div class="form-group col-md-4">
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
					</div> --}}

{{-- 					<div class="form-group col-md-2">
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
					</div> --}}
				</div>
				<!-- /. row -->
            </div>

            <div class="modal-footer">
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

            </div>
        </div>
    </div>
</div>

</form>