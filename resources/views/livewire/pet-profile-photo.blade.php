<div class="p-3">
    <form x-data="imgPreview" x-cloak wire:submit.prevent="updatePhoto">
        <!-- Current Profile Photo -->
        <template x-if="imgsrc">
            <div class="mt-4 mb-2 widget-user-image">
                <img class="rounded-circle img-fluid elevation-1"
                    :src="imgsrc"
                    style="width: 48px; height: 48px; object-fit: cover;"
                    alt="{{ $this->pet->name }}">
            </div>
        </template>

        <div class="my-4">
            <input type="file"
                wire:model.lazy="photo"
                id="imgSelect"
                accept="image/*"
                x-ref="myFile"
                @change="previewFile"
                style="display: none;">
            <button type="button"
                class="btn btn-default btn-sm text-uppercase"
                onclick="document.getElementById('imgSelect').click();">
                    Select a new photo
             </button>

             @if($this->pet->image)
                <button type="button"
                    class="btn btn-default btn-sm text-uppercase"
                    wire:click.prevent='removePhoto'>
                        Remove photo
                </button>
            @endif

            @error('photo')
                <p class="text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="float-right">
            @if (session()->has('message'))
                <span x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                    x-transition.duration.1500ms
                    class="mr-2">
                    {{ session('message') }}
                </span>
            @endif

            <button class="btn bg-navy text-uppercase" wire:loading.class="disabled" {{-- style="background: #1f2937;" --}}>
                    <span wire:loading.remove wire:target="updatePhoto" >
                       {{ __('Save') }}
                    </span>
                    <span wire:loading wire:target="updatePhoto">
                        <div class="spinner-grow spinner-grow-sm"></div>
                        {{ __('Saving') }}
                    </span>
            </button>
        </div>
    </form>
</div>


<script type="text/javascript">
    document.addEventListener('alpine:init', () => {
        Alpine.data('imgPreview', () => ({
            imgsrc:'{{$pet->pet_profile_photo ? asset('storage/pet-profile-photos/' . $pet->pet_profile_photo) : 'https://ui-avatars.com/api/?name='.$pet->name.'&color=FFF&background=random&size=128'}}',
            previewFile() {
                let file = this.$refs.myFile.files[0];
                if(!file || file.type.indexOf('image/') === -1) return;
                this.imgsrc = '{{ asset('storage/pet-profile-photos/' . $this->pet->pet_profile_photo) }}';
                let reader = new FileReader();

                reader.onload = e => {
                    this.imgsrc = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        }))
    });
</script>


{{-- <button type="submit" class="btn btn-outline-link disabled">
  <img src="{{asset('storage/pet-profile-photos/plus.svg')}}" height="36"/>
</button>
<button type="submit" class="btn btn-outline-link">
  <img src="{{asset('storage/pet-profile-photos/plus.svg')}}" height="36"/>

</button>
<button type="submit" class="btn btn-outline-link disabled">
  <img src="{{asset('storage/pet-profile-photos/undo.svg')}}" height="36"/>
  undo

</button>
<button type="submit" class="btn btn-outline-link">
  <img src="{{asset('storage/pet-profile-photos/undo.svg')}}" height="36"/>
undo
</button>

<button type="submit" class="btn btn-default btn-sm disabled">
  <img src="{{asset('storage/pet-profile-photos/trash.svg')}}" height="28px" />
</button>
<button type="submit" class="btn btn-default btn-sm">
  <img src="{{asset('storage/pet-profile-photos/trash.svg')}}" height="28px" />
</button>

<br>
<button type="submit" class="btn btn-outline-link disabled">
next
  <img src="{{asset('storage/pet-profile-photos/next.svg')}}" height="36"/>
</button>
<button type="submit" class="btn btn-outline-link">
    next
  <img src="{{asset('storage/pet-profile-photos/next.svg')}}" height="36"/>
</button>

<button type="submit" class="btn btn-outline-link disabled">
  <img src="{{asset('storage/pet-profile-photos/back.svg')}}" height="36"/>
  previous
</button>
<button type="submit" class="btn btn-outline-link">
  <img src="{{asset('storage/pet-profile-photos/back.svg')}}" height="36"/>
  previous
</button> --}}