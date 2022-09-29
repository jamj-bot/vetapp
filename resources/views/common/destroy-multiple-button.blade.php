<button id="destroyMultiple" wire:click="destroyMultiple" type="button" class="btn btn-default btn-block {{ $this->select_page ? '' : 'd-none' }}">
  <i class="fas fa-fw fa-trash"></i>
  Delete <span id="counter" class="font-weight-bold">{{ count($this->selected) }}</span> items
</button>