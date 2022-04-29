<form autocomplete="off">
	@include('common.modal-header')

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputName" class="form-label font-weight-normal">Name</label>
				<input wire:model.lazy="name"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('name') ? 'is-invalid':'' }}
					{{ $errors->has('name') == false && $this->name != null ? 'is-valid border-success':'' }}"
					id="inputName"
					placeholder="e.g. Perro"
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

			<div class="form-group col-md-6">
				<label for="inputScinetificName" class="form-label font-weight-normal">Scientific name</label>
				<input wire:model.lazy="scientific_name"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('scientific_name') ? 'is-invalid':'' }}
					{{ $errors->has('scientific_name') == false && $this->scientific_name != null ? 'is-valid border-success':'' }}"
					id="inputScinetificName"
					placeholder="e.g. Cannis Familiaris"
					aria-describedby="inputScientificNameFeedback">

				@error('scientific_name')
					<div id="inputScientificNameFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
                @else
                    <div id="inputScientificNameFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>
		</div>
		<!-- /. row -->

	@include('common.modal-footer')
</form>