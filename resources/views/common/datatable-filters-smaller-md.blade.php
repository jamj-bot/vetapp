<div class="row p-0 d-md-none">
    <div class="col-12">
        <div class="form-row">
            <div class="form-group col-12 {{-- col-sm-6 --}}">
                <label for="inputSearch" class="sr-only">Search items</label>
                <input type="search" wire:model="search" class="form-control {{-- form-control-sm  --}}form-control-border" id="inputSearch" placeholder="Type your search term">
            </div>

            <div class="form-group col-4 {{-- col-sm-6 --}}">
                <label for="inputSort" class="sr-only">Sort by</label>
                <select wire:model="sort" class="custom-select custom-select-sm form-control-border" id="inputSort">
                    <option disabled>Choose...</option>

                    {{-- Options for Pets index--}}
                    @if($pageTitle == 'Pets index')
                        <option value="name">Pet name</option>
                        <option value="breed">Breed</option>
                        <option value="common_name">Species</option>
                        <option value="status">Status</option>
                        <option value="user_name">Owner</option>
                        <option value="updated_at">Updated</option>
                    @endif

                    {{-- Options for Owner's pets--}}
                    @if($pageTitle == 'Pets')
                        <option value="code">Code</option>
                        <option value="name">Name</option>
                        <option value="breed">Breed</option>
                        <option value="common_name">Species</option>
                        <option value="pets.updated_at">Updated</option>
                    @endif

                    {{-- Options for Owner's pets--}}
                    @if($pageTitle == 'Species')
                        <option value="name">Common name</option>
                        <option value="scientific_name">Scientific name</option>
                    @endif

                </select>
            </div>

            <div class="form-group col-4 {{-- col-sm-6 --}}">
                <label for="inputOrder" class="sr-only">Order by</label>
                <select wire:model="direction" class="custom-select custom-select-sm form-control-border" id="inputOrder">
                    <option disabled>Choose...</option>
                    <option value="desc">DESC</option>
                    <option value="asc">ASC</option>
                </select>
            </div>

            <div class="form-group col-4 {{-- col-sm-6 --}}">
                <label for="inputPaginate" class="sr-only">Show</label>
                <select wire:model="paginate" wire:change="resetPagination" class="custom-select custom-select-sm form-control-border" id="inputPaginate">
                    <option disabled>Choose...</option>
                    <option value="10">10 items</option>
                    <option selected value="25">25 items</option>
                    <option selected value="50">50 items</option>
                    <option value="100">100 items</option>
                </select>
            </div>
        </div>
    </div>
</div>