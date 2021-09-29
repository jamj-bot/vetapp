<form wire:submit.prevent="{{ $selected_id < 0 ? 'store()' : 'update()' }}">
	@include('common.modal-header')

	  	<div class="form-group">
	    	<label for="inputName">Name</label>
	    	<input wire:model.lazy="name" type="text" class="form-control" id="inputName" placeholder="John Doe">
	    	@error('name') <span class="text-danger text-xs">{{ $message }}</span> @enderror
	  	</div>

		<div class="form-row">
		  	<div class="form-group col-md-6">
		    	<label for="inputPhone">Phone</label>
		    	<input wire:model.lazy="phone" type="text" class="form-control" id="inputPhone" placeholder="3301020304">
		    	@error('phone') <span class="text-danger text-xs">{{ $message }}</span> @enderror
		  	</div>
		  	<div class="form-group col-md-6">
	      		<label for="inputEmail">Email</label>
	      		<input wire:model.lazy="email" type="email" class="form-control" id="inputEmail" placeholder="Email@example.com">
	      		@error('email') <span class="text-danger text-xs">{{ $message }}</span> @enderror
	    	</div>
	  	</div>


	  	<div class="form-row">
	    	<div class="form-group col-md-6">
	      		<label for="inputPassword">Password</label>
	      		<input wire:model.lazy="password" type="password" class="form-control" id="inputPassword" placeholder="Password">
	      		@error('password') <span class="text-danger text-xs">{{ $message }}</span> @enderror
	    	</div>
	    	<div class="form-group col-md-4">
	      		<label for="inputUserType">User type</label>
	      		<select wire:model.lazy="user_type" id="inputUserType" class="form-control">
	        		<option value="choose" selected>Choose...</option>
	        		@foreach($roles as $role)
	        			<option value="{{ $role->name }}">{{ $role->name }}</option>
	        		@endforeach
	      		</select>
	      		@error('user_type') <span class="text-danger text-xs">{{ $message }}</span> @enderror
	    	</div>
	    	<div class="form-group col-md-2">
	      		<label for="inputStatus">Status</label>
	      		<select wire:model.lazy="status" id="inputStatus" class="form-control">
	        		<option value="choose" selected>Choose...</option>
	        		<option value="active">Active</option>
	        		<option value="locked">Locked</option>
	      		</select>
	      		@error('status') <span class="text-danger text-xs">{{ $message }}</span> @enderror
	    	</div>
	  	</div>

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
