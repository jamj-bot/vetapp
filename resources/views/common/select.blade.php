<div class="form-group">
    <div class="input-group input-group-sm">
        <div class="input-group-prepend">
            <label class="input-group-text" for="selectShowItems">Showing</label>
        </div>
        <select wire:model="paginate" wire:change="resetPagination" class="custom-select custom-select-sm" id="selectShowItems">
            <option disabled>Choose...</option>
            <option value="10">10 items</option>
            <option selected value="25">25 items</option>
            <option selected value="50">50 items</option>
            <option value="100">100 items</option>
        </select>
    </div>
</div>