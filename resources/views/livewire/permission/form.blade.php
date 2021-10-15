<form wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
	@include('common.modal-header')

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="inputName" class="form-label font-weight-normal">Name *</label>
            <input wire:model.lazy="name"
                type="text"
                class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid':'' }}"
                id="inputName"
                placeholder="e.g. permissions_index"
                aria-describedby="inputNameFeedback">

            @error('name')
                <div id="inputNameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>
    </div>
    <!-- /. row -->


	@include('common.modal-footer')
</form>