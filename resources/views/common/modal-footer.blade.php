
            </div>

            <div class="modal-footer">
                <div wire:loading.class="overlay dark" wire:target="submit">
                    <div class="" wire:loading wire:target="submit">
                        <div class="d-flex justify-content-center"><span class="loader"></span></div>
                        <div class="text-xl lead font-weight-bold">{{ $this->selected_id ? 'Updating...' : 'Saving...'}}</div>
                    </div>
                </div>

                <button type="button" wire:click.prevent="resetUI" class="btn bg-gradient-danger" data-dismiss="modal">
                    Close
                </button>

                <button type="submit" class="btn bg-gradient-primary">
                    <span wire:loading.remove wire:target="submit">
                        <i class="fas fa-fw fa-save"></i>
                        {{ $this->selected_id ? 'Update' : 'Save'}}
                    </span>
                    <span wire:loading wire:target="submit">
                        <i class="fas fa-fw fa-spinner fa-spin"></i>
                        {{ $this->selected_id ? 'Updating' : 'Saving'}}
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>