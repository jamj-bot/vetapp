
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>

                @if($selected_id > 0)
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary">Save changes</button>
                @else
                    <button type="button" wire:click.prevent="store()" class="btn btn-primary">Save</button>
                @endif
            </div>
        </div>
    </div>
</div>
