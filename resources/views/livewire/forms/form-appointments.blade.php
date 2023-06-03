
<form autocomplete="off" wire:submit.prevent="submit">
    @include('common.modal-header')

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="selectVeterinarianId" class="form-label font-weight-normal"> Veterinarian *</label>
                <select wire:model.lazy="veterinarian_id"
                    class="custom-select custom-select-sm
                    {{ $errors->has('veterinarian_id') ? 'is-invalid':'' }}
                    {{ $errors->has('veterinarian_id') == false && $this->veterinarian_id != 'choose' ? 'is-valid border-success':'' }}"
                    id="selectVeterinarianId"
                    aria-describedby="selectVeterinarianIdFeedback">
                    <option value="choose" selected disabled>Choose a vet</option>
                        @foreach($veterinarians as $veterinarian)
                            <option value="{{ $veterinarian->veterinarian->id }}">{{ $veterinarian->name }}</option>
                        @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputStartTime" class="form-label font-weight-normal">Start time *</label>
                <input wire:model.lazy="start_time"
                    type=""
                    class="form-control form-control-sm flatpickr
                    {{ $errors->has('start_time') ? 'is-invalid':'' }}
                    {{ $errors->has('start_time') == false && $this->start_time != null ? 'is-valid border-success':'' }}"
                    id="inputStartTime"
                    placeholder="Date and time"
                    aria-describedby="inputStartTimeFeedback">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="form-label font-weight-normal"> Services *</label>
                <div class="row">
                    @foreach($services_list as $key => $service)
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="form-check-inline  icheck-greensea">
                                <input class="form-check-input  {{ $errors->has('selected_services.*') ? 'is-invalid':'' }}
                                    {{ $errors->has('selected_services.*') == false && $this->selected_services != null ? 'is-valid border-success':'' }}"
                                    type="checkbox"
                                    id="inlineCheckbox{{$service->id}}"
                                    wire:model.defer="selected_services"
                                    value="{{ (int) $service->id }}"
                                    aria-describedby="selectSelectedServicesFeedback">
                                <label class="form-check-label" for="inlineCheckbox{{$service->id}}">
                                    {{ $service->service_name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-check-inline  icheck-greensea">
                    <input class="form-check-input  {{ $errors->has('selected_services.*') ? 'is-invalid':'' }}
                        {{ $errors->has('selected_services.*') == false && $this->selected_services != null ? 'is-valid border-success':'' }}"
                        type="checkbox"
                        id="inlineCheckbox200"
                        wire:model.defer="selected_services"
                        value="200"
                        aria-describedby="selectSelectedServicesFeedback">
                    <label class="form-check-label" for="inlineCheckbox200">
                        200
                    </label>
                </div>
            </div>
        </div>

        <!-- Errors / session messages -->
        <div class="form-row">
            @if (session()->has('message'))
                <div>
                    <ul>
                        <li class="text-xs text-danger">{{ session('message') }}</li>
                    </ul>
                </div>
            @endif
            <!-- Errors -->
            @if ($errors->any())
                <div class="text-sm text-danger float-right">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif
            <!-- ./ Errors -->
        </div>

    @include('common.modal-footer')
</form>