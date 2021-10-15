
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn bg-gradient-danger" data-dismiss="modal">
                    Close
                </button>

                @if($selected_id > 0)
                    <button type="button" wire:click.prevent="update()" class="btn bg-gradient-primary">Save changes</button>
                @else
                    <button type="button" wire:click.prevent="store()" class="btn bg-gradient-primary">Save</button>
                @endif
            </div>
        </div>
    </div>
</div>
