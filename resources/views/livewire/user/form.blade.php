<form wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}" autocomplete="off">
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
					placeholder="e.g. John Doe or Lehn Farms LLC"
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
				<label for="inputPhone" class="form-label font-weight-normal">Phone *</label>
				<input wire:model.lazy="phone"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('phone') ? 'is-invalid':'' }}
					{{ $errors->has('phone') == false && $this->phone != null ? 'is-valid border-success':'' }}"
					id="inputPhone"
					placeholder="e.g. 3301020304"
					aria-describedby="inputPhoneFeedback">

			   @error('phone')
					<div id="inputPhoneFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
		        @else
                    <div id="inputPhoneFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

			<div class="form-group col-md-4">
				<label for="inputEmail" class="form-label font-weight-normal">Email *</label>
				<input wire:model.lazy="email"
					type="text"
					class="form-control form-control-sm
					{{ $errors->has('email') ? 'is-invalid':'' }}
					{{ $errors->has('email') == false && $this->email != null ? 'is-valid border-success':'' }}"
					id="inputEmail"
					placeholder="e.g. john_doe@gmail.com"
					aria-describedby="inputEmailFeedback">

				@error('email')
					<div id="inputEmailFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
		        @else
                    <div id="inputEmailFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputPassword" class="form-label font-weight-normal">Password *</label>
				<input wire:model.lazy="password"
					type="password"
					class="form-control form-control-sm
					{{ $errors->has('password') ? 'is-invalid':'' }}
					{{ $errors->has('password') == false && $this->password != null ? 'is-valid border-success':'' }}"
					id="inputPassword"
					placeholder=""
					aria-describedby="inputPasswordFeedback">

			   @error('password')
					<div id="inputPasswordFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
		        @else
                    <div id="inputPasswordFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>

			<div class="form-group col-md-6">
				<label for="inputConfirmPassword" class="form-label font-weight-normal">Confirm password *</label>
				<input wire:model.lazy="confirmPassword"
					type="password"
					class="form-control form-control-sm
					{{ $errors->has('confirmPassword') ? 'is-invalid':'' }}
					{{ $errors->has('confirmPassword') == false && $this->confirmPassword != null ? 'is-valid border-success':'' }}"
					id="inputConfirmPassword"
					placeholder=""
					aria-describedby="inputConfirmPasswordFeedback">

			   @error('confirmPassword')
					<div id="inputConfirmPasswordFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
		        @else
                    <div id="inputConfirmPasswordFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>
		</div>
		<!-- /. row -->

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="selectUserType" class="form-label font-weight-normal">User type *</label>
				<select wire:model.lazy="user_type"
					class="custom-select custom-select-sm
					{{ $errors->has('user_type') ? 'is-invalid':'' }}
					{{ $errors->has('user_type') == false && $this->user_type != 'choose' ? 'is-valid border-success':'' }}"
					id="selectUserType"
					aria-describedby="selectUserTypeFeedback">
					<option value="choose" selected>Choose...</option>
					@foreach($roles as $role)
						<option value="{{ $role->name }}">{{ $role->name }}</option>
					@endforeach
				</select>

				@error('user_type')
					<div id="selectUserTypeFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
		        @else
                    <div id="selectUserTypeFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror
			</div>

			<div class="form-group col-md-6">
				<label for="selectStatus" class="form-label font-weight-normal">Status *</label>
				<select wire:model.lazy="status"
					class="custom-select custom-select-sm
					{{ $errors->has('status') ? 'is-invalid':'' }}
					{{ $errors->has('status') == false && $this->status != 'choose' ? 'is-valid border-success':'' }}"
					id="selectStatus"
					aria-describedby="selectStatusFeedback">
	        		<option value="choose" selected>Choose...</option>
	        		<option value="active">Active</option>
	        		<option value="locked">Locked</option>
				</select>

				@error('status')
					<div id="selectStatusFeedback" class="invalid-feedback">
						{{ $message }}
					</div>
		        @else
                    <div id="selectStatusFeedback" class="valid-feedback">
                        Looks good!
                    </div>
				@enderror

			</div>
		</div>
		<!-- /. row -->

	  	<div class="form-group">
	    	<div class="form-check">
	      		<input class="form-check-input" type="checkbox" id="gridCheck">
	      			<label class="form-check-label" for="gridCheck">
	        		Check me out
	      			</label>
	    	</div>
	  	</div>

	@include('common.modal-footer')
</form>
