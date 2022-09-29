<div wire:ignore.self class="modal fade" id="modalFormApply" tabindex="-1" role="dialog" aria-labelledby="modalFormApplyLabel" data-backdrop="static" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormApplyLabel">
                        <span>Vaccination</span> | {{ $applied == 0 ? 'Apply' : 'Apply (undo)' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="apply()" autocomplete="off">
                        <div class="form-group col-12">
                            <label for="inputBatchNumber" class="form-label font-weight-normal">Batch Number *</label>
                            <input wire:model.lazy="batch_number"
                                type="text"
                                class="form-control form-control-sm {{ $errors->has('batch_number') ? 'is-invalid':'' }}"
                                id="inputBatchNumber"
                                placeholder="e.g. 123-MP-1L2O"
                                aria-describedby="inputBatchNumberFeedback">

                            @error('batch_number')
                                <div id="inputBatchNumberFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn bg-gradient-danger" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit"
                        wire:click.prevent="apply" wire:loading.attr="disabled"
                        class="btn bg-gradient-primary">

                        <span wire:loading.remove wire:target="apply">
                            <i class="fas fa-syringe"></i>
                            {{ $applied == 0 ? 'Apply' : 'Undo' }}
                        </span>
                        <span wire:loading wire:target="apply">
                            <i class="fas fa-fw fa-spinner fa-spin"></i>
                            {{ $applied == 0 ? 'Apply' : 'Undo' }}
                        </span>
                    </button>
                </div>
            </div>
        </div>

</div>