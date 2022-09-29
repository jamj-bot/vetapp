<div class="mt-4">
    <form {{-- wire:submit.prevent="changeOwner()" --}}>
        <div wire:ignore>
            <label for="select2-dropdown" class="sr-only">Change owner</label>
            <select class="form-control" id="select2-dropdown" aria-describedby="select2DropdownFeedback">
                <option value="" selected>Select a new owner</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} .- {{ $user->email }}</option>
                @endforeach
            </select>
        </div>

        @error('userIdSelected')
                <span id="select2DropdownFeedback" class="error text-danger text-xs">{{ $message }}</span>
        @enderror

        <div class="float-right mt-4">
            <button type="button" wire:click.prevent="resetUI()" class="btn bg-gradient-secondary">
                    Cancel
            </button>
            <button type="button" class="btn bg-gradient-danger" type="submit" wire:click.prevent="changeOwner">
                Change owner
            </button>
        </div>

    </form>
</div>


{{-- https://github.com/ttskch/select2-bootstrap4-theme --}}
<link rel="stylesheet" href="/path/to/select2.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){
        $('#select2-dropdown').select2({
            theme: 'bootstrap4',
            width: '100%'
        });

        $('#select2-dropdown').on('change', function (e) {
            var uId = $('#select2-dropdown').select2("val");
            var uName = $('#select2-dropdown option:selected').text();
            @this.set('userIdSelected', uId);
            @this.set('userNameSelected', uName);
        });
    });
</script>
