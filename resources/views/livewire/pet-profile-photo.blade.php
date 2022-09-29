<div>
    <form x-data="imgPreview" x-cloak wire:submit.prevent="updatePhoto">
        <!-- Current Profile Photo -->
        <template x-if="imgsrc">
            <div class="mt-4 mb-2 widget-user-image">
                <img class="img-fluid img-circle elevation-2 shadow border border-3"
                    :src="imgsrc"
                    style="width: 100px; height: 100px; object-fit: cover; background: antiquewhite;"
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
                        <i class="fas fa-fw fa-spinner fa-spin"></i>
                        {{ __('Saving') }}
                    </span>
            </button>
        </div>
    </form>
</div>


<script type="text/javascript">
    document.addEventListener('alpine:init', () => {
        Alpine.data('imgPreview', () => ({
            imgsrc:'{{ asset('storage/pet-profile-photos/' . $this->pet->pet_profile_photo) }}',
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
