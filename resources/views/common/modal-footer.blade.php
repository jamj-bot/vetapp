
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn bg-gradient-danger" data-dismiss="modal">
                    Close
                </button>

{{--                 @if($selected_id > 0)
                    <button type="submit" wire:click.prevent="update" wire:loading.attr="disabled" class="btn bg-gradient-primary">
                        <span wire:loading.remove wire:target="update">
                            <i class="fas fa-fw fa-edit"></i>
                            Update
                        </span>
                        <span wire:loading wire:target="update">
                            <i class="fas fa-fw fa-spinner fa-spin"></i>
                            Updating...
                        </span>
                    </button>
                @else
                    <button type="submit" wire:click.prevent="store" wire:loading.attr="disabled" class="btn bg-gradient-primary">
                        <span wire:loading.remove wire:target="store">
                        <i class="fas fa-fw fa-save"></i>
                            Save
                        </span>
                        <span wire:loading wire:target="store">
                            <i class="fas fa-fw fa-spinner fa-spin"></i>
                            Saving...
                        </span>
                    </button>
                @endif --}}


                <button type="submit"
                    {{ $selected_id > 0 ? '' : 'hidden' }}
                    wire:click.prevent="update" wire:loading.attr="disabled"
                    class="btn bg-gradient-primary">

                    <span wire:loading.remove wire:target="update">
                        <i class="fas fa-fw fa-edit"></i>
                        Update
                    </span>
                    <span wire:loading wire:target="update">
                        <i class="fas fa-fw fa-spinner fa-spin"></i>
                        Update
                    </span>
                </button>


                <button type="submit"
                    {{ $selected_id > 0 ? 'hidden' : '' }}
                    wire:click.prevent="store" wire:loading.attr="disabled"
                    class="btn bg-gradient-primary">

                    <span wire:loading.remove wire:target="store">
                    <i class="fas fa-fw fa-save"></i>
                        Save
                    </span>
                    <span wire:loading wire:target="store">
                        <i class="fas fa-fw fa-spinner fa-spin"></i>
                        Save
                    </span>
                </button>

            </div>
        </div>
    </div>
</div>