<form wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
	@include('common.modal-header')

        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input wire:model.lazy="name"
                    type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
                    id="inputName"
                    placeholder="e.g. admin"
                    aria-describedby="inputNameFeedback">

                @error('name')
                    <div id="inputNameFeedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>
        </div>

	@include('common.modal-footer')
</form>