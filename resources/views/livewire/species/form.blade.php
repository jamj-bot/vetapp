<form autocomplete="off">
	@include('common.modal-header')

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputName" class="form-label font-weight-normal">Name</label>
				<input wire:model.lazy="name"
					type="text"
					class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid':'' }}"
					id="inputName"
					placeholder="e.g. Perro"
					aria-describedby="inputNameFeedback">

				@error('name')
					<div id="inputNameFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>

			<div class="form-group col-md-6">
				<label for="inputScinetificName" class="form-label font-weight-normal">Scientific name</label>
				<input wire:model.lazy="scientific_name"
					type="text"
					class="form-control form-control-sm {{ $errors->has('scientific_name') ? 'is-invalid':'' }}"
					id="inputScinetificName"
					placeholder="e.g. Cannis Familiaris"
					aria-describedby="inputScientificNameFeedback">

				@error('scientific_name')
					<div id="inputScientificNameFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
				@enderror
			</div>
		</div>
		<!-- /. row -->

	@include('common.modal-footer')
</form>