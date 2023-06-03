<div class="d-none d-md-block">
    <div class="d-flex justify-content-start">
        <div class="mr-2">
            <button type="button"
                wire:click.prevent="undoMultiple"
                title="Undo"
                class="btn btn-default btn-block btn-sm shadow-sm border-0 {{ $this->deleted ? '' : 'd-none'}}"
                wire:loading.attr="disabled" wire:target="undoMultiple">
                    <span wire:loading.remove wire:target="undoMultiple">
                        <i class="fas fa-fw fa-undo"></i> Undo
                    </span>
                    <span wire:loading wire:target="undoMultiple">
                        <i class="fas fa-fw fa-spinner fa-spin"></i> Undoing
                    </span>
            </button>
        </div>
        <div>
            <button id="destroyMultiple{{$this->pageTitle}}" type="button" wire:click="destroyMultiple"
                class="btn bg-gradient-danger btn-block btn-sm shadow-sm border-0 {{ $this->select_page ? '' : 'd-none' }}"
                wire:loading.attr="disabled"  wire:target="destroyMultiple">
                    <span wire:loading.remove wire:target="destroyMultiple">
                        <i class="fas fa-fw fa-trash"></i>Delete {{ Str::of($this->pageTitle)->plural() }}
                    </span>
                    <span wire:loading wire:target="destroyMultiple">
                        <i class="fas fa-fw fa-spinner fa-spin"></i> Deleting {{ Str::of($this->pageTitle)->plural() }}
                    </span>
            </button>
        </div>
    </div>
</div>