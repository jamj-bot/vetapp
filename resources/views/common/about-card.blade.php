<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">About
            @if($pet->name)
                {{ $pet->name }}
            @else
                Nameless <span class="text-muted text-xs">{{ $pet->code }}</span>
            @endif
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <i class="fas fa-fw fa-microchip mr-1" style="color: #3784b9" title="Code"></i>
                {{-- <img src="{{asset('storage/icons/barcode.svg')}}" height="18"/> --}}
                <span class="sr-only">Code</span>
                {{ $pet->code }}
            </li>

            <li class="list-group-item">
                <div x-data="{ open: false }">
                    <div @click="open = ! open" title="More" style="cursor: pointer">
                        <i class="fas fa-fw fa-birthday-cake mr-1" style="color: #4b85cb" title="Date of birth"></i>
                        <span class="sr-only">Date of birth</span>
                        {{ $pet->dob->format('d-m-Y') }} <sup class="text-muted">{{$pet->estimated ? 'est.' : ''}}</sup>
                        <span class="float-right"><i class="fas fa-caret-down text-xs text-muted"></i></span>
                    </div>

                    <div x-show="open" class="mb-0" x-collapse.duration.750ms @click.outside="open = false">
                        <i class="fas fa-fw fa-birthday-cake mr-1 mt-3" style="color: #6b84da" title="Age"></i>
                        <span class="sr-only">Age</span>
                        {{ \Carbon\Carbon::createFromDate($pet->dob)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }} <sup class="text-muted">{{$pet->estimated ? 'est.' : ''}}</sup>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <div x-data="{ open: false }">
                    <div @click="open = ! open" title="More"  style="cursor: pointer">
                        <i class="fas fa-fw fa-paw mr-1" style="color: #9080e2" title="Species"></i>
                        <span class="sr-only">Species</span>
                        {{ $pet->species->name }}
                        <span class="float-right"><i class="fas fa-caret-down text-xs text-muted"></i></span>
                    </div>

                    <div x-show="open" class="mb-0 font-italic" x-collapse.duration.750ms @click.outside="open = false">
                        <i class="fas fa-fw fa-paw mr-1 mt-3" style="color: #b878e2" title="Scientific name"></i>
                        <span class="sr-only">Scientific name</span>
                        {{ $pet->species->scientific_name }}
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <i class="fas fa-fw fa-award mr-1" style="color: #de6dda" title="Breed"></i>
                <span class="sr-only">Breed</span>
                {{ $pet->breed ? $pet->breed : 'Crossbreed / undetermined' }}
            </li>

            @if(count($pet->consultations()->get()))
                <li class="list-group-item">
                    <i class="fas fa-fw fa-weight mr-1" style="color: #cb67d7" title="Body condition"></i>
                    <span class="sr-only">Body condition</span>
                    {{ $pet->consultations()->latest()->first()->body_condition }}
                    <span class="text-muted text-xs"> / {{ $pet->consultations()->latest()->first()->created_at->diffForHumans() }}</span>
                </li>
            @endif

            <li class="list-group-item">
                <i class="fas fa-fw fa-venus mr-1" style="color: #b861d3" title="Sex"></i>
                <span class="sr-only">Sex</span>
                {{ $pet->sex }}
            </li>

            <li class="list-group-item">
                <i class="fas fa-fw fa-hard-hat mr-1" style="color: #a45bcf" title="Zootechnical function"></i>
                <span class="sr-only">Zootechnical function</span>
                {{ $pet->zootechnical_function }}
            </li>

            <li class="list-group-item">
                <i class="fas fa-fw fa-neuter mr-1" style="color: #8e56cb" title="Desexed"></i>
                <span class="sr-only">Desexed</span>
                {{ $pet->desexed }}
                @if( $pet->desexed != 'Desexed')
                    <span class="text-muted text-xs">
                        {{$pet->desexing_candidate ? '/ candidate' : '/ not candidate'}}
                    </span>
                @endif
            </li>
            <li class="list-group-item">
                <i class="fas fa-fw fa-calendar mr-1" style="color: #7851c6" title="Registered at"></i>
                <span class="sr-only">Registered</span>
                Registered {{ $pet->created_at->diffForHumans() }}
            </li>
        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->