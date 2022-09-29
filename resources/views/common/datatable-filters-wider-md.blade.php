<div class="row d-none d-md-block">
    <div class="col-12">
        <div class="form-row d-flex justify-content-end">
            <div class="form-group col-md-3">
                <label for="inputPaginate" class="sr-only">Show</label>
                <select wire:model="paginate" wire:change="resetPagination" class="custom-select custom-select-sm form-control-border" id="inputPaginate">
                    <option disabled>Choose...</option>
                    <option value="10">10 items</option>
                    <option selected value="25">25 items</option>
                    <option selected value="50">50 items</option>
                    <option value="100">100 items</option>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="inputSearch" class="sr-only">Search items</label>
                <input type="search" wire:model="search" class="form-control form-control-sm form-control-border" id="inputSearch" placeholder="Search...">
            </div>
        </div>
    </div>
</div>