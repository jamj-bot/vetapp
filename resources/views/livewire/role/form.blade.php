<form autocomplete="off" wire:submit.prevent="submit">
	@include('common.modal-header')

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="inputName" class="form-label font-weight-normal">Name *</label>
            <input wire:model.lazy="name"
                type="text"
                class="form-control form-control-sm
                {{ $errors->has('name') ? 'is-invalid':'' }}
                {{ $errors->has('name') == false && $this->name != null ? 'is-valid border-success':'' }}"
                id="inputName"
                placeholder="e.g. admin"
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
    </div>
    <!-- /. row -->

	@include('common.modal-footer')
</form>