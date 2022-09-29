<?php

namespace App\Http\Livewire;

use App\Models\Species;
use App\Models\Vaccination;
use App\Models\Vaccine;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VaccineController extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Datatable attributes
    public $paginate = '50', $sort = 'name', $direction = 'asc', $readyToLoad = false, $search = '';

    // General attributes
    public $pageTitle, $modalTitle;

    // Stepper
    public $currentStep = 1;

    public $steps = [
        1 => [
            'heading'    => 'General information',
        ],
        2 => [
            'heading'    => 'Target species',
        ],
        3 => [
            'heading'    => 'Instructions',
        ]
    ];

    // CRUD attributes
    public $selected_species = [],
        $name,
        $type,
        $manufacturer,
        $description,
        $status = 'choose',
        $dosage,
        $administration,
        $vaccination_schedule,
        $primary_doses,
        $revaccination_schedule,
        $revaccination_doses,
        $selected_id;

    // Listeners
    protected $listeners = [
        'destroy' => 'destroy',
    ];

    /**
     *  Query string than  urls with datatable filters
     *
     **/
    protected $queryString = [
        'search'    => ['except' => ''],
        'paginate'  => ['except' => '50'],
        'sort'      => ['except' => 'name'],
        'direction' => ['except' => 'asc']
    ];

    /**
     *  Validation rules by steps (for stepper)
     *
     **/
    private $validationRules = [
        1 => [
            'name'         => ['required', 'string', 'min:3', 'max:140'],
            'type'         => ['required', 'string', 'min:3', 'max:140'],
            'manufacturer' => ['required', 'string', 'min:3', 'max:140'],
            'description'  => ['required', 'string', 'min:3', 'max:3000'],
            'status'       => ['required', 'in:"Required", "Recommended", "Optional"'],
        ],
        2 => [
            'selected_species' => ['required', 'array'],
        ],
        3 => [
            'dosage'                 => ['required', 'string', 'min:3', 'max:255'],
            'administration'         => ['required', 'string', 'min:3', 'max:255'],
            'vaccination_schedule'   => ['required', 'string', 'min:3', 'max:255'],
            'primary_doses'          => ['required', 'integer', 'integer', 'between:1,10'],
            'revaccination_schedule' => ['required', 'string', 'min:3', 'max:255'],
            'revaccination_doses'    => ['required', 'integer', 'integer', 'between:0,10'],
        ]
    ];

     /**
     *  Function that returns the validation rules
     *
    **/
    // protected function rules()
    // {
    //     return [
    //         'selected_species'       => 'required|array',
    //         'name'                   => 'required|string|min:3|max:140',
    //         'type'                   => 'required|string|min:3|max:140',
    //         'manufacturer'           => 'required|string|min:3|max:140',
    //         'description'            => 'required|string|min:3|max:3000',
    //         'status'                 => 'required|in:"Required", "Recommended", "Optional"',
    //         'dosage'                 => 'required|string|min:3|max:255',
    //         'administration'         => 'required|string|min:3|max:255',
    //         'vaccination_schedule'   => 'required|string|min:3|max:255',
    //         'primary_doses'          => 'required|integer|between:1,10',
    //         'revaccination_schedule' => 'required|string|min:3|max:255',
    //         'revaccination_doses'    => 'required|integer|between:0,10'
    //     ];
    // }

    /**
     *  Real time validation
     *
    **/
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->validationRules[$this->currentStep]);
    }

    /**
     *  Funtion to reset pagination when a user writtes in search field
     *
    **/
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     *  Funtion to reset pagination when a filter changes
     *
    **/
    public function resetPagination()
    {
        $this->resetPage();
    }


    public function goToNextStep()
    {
        $this->validate($this->validationRules[$this->currentStep]);
        $this->currentStep++;

    }

    public function goToPreviousStep()
    {
        $this->currentStep--;
    }

    /**
     * Function para seleccionar el orden de los datos
     *
    **/
    public function order($sort)
    {

        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    /**
     *  function para verificar si la página ya se cargó.
     *
    **/
    public function loadItems()
    {
        $this->readyToLoad = true;
    }

    public function mount()
    {
        $this->pageTitle = 'Vaccines';
        $this->modalTitle = "Vaccine";
    }

    public function render()
    {
        $this->authorize('vaccines_index');

        if ($this->readyToLoad) {
            if (strlen($this->search) > 0 ) {
                $vaccines = Vaccine::where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('manufacturer', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);

            } else {
                $vaccines = Vaccine::orderBy($this->sort, $this->direction)->paginate($this->paginate);
            }
        } else {
            $vaccines = [];
        }

        $speciesList = Species::select('id', 'name', 'scientific_name')
            ->orderBy('name')
            ->get();

        return view('livewire.vaccine.component', compact('vaccines', 'speciesList'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function store()
    {
        $this->authorize('vaccines_store');

        // Usando validation rules by steps
        $rules = collect($this->validationRules)->collapse()->toArray();
        $validatedData = $this->validate($rules);

        $vaccine = Vaccine::create($validatedData);

        $vaccine->species()->attach($this->selected_species);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => $vaccine->name . ' has been stored.'
        ]);
    }

    public function edit(Vaccine $vaccine)
    {
        // Recupera el array de ids con formato de string
        $this->selected_species = $vaccine->species->pluck('id')->map(fn ($item) => (string) $item)->toArray();

        // $this->selected = $this->species->pluck('id')->map(fn ($item) => (string) $item)->toArray();

        // foreach ($this->selected_species as $key => $id) {
        //     $this->selected_species[$key] = strval($id);
        // }

        $this->selected_id = $vaccine->id;
        $this->name = $vaccine->name;
        $this->type = $vaccine->type;
        $this->manufacturer = $vaccine->manufacturer;
        $this->description = $vaccine->description;
        $this->status = $vaccine->status;
        $this->dosage = $vaccine->dosage;
        $this->administration = $vaccine->administration;
        $this->vaccination_schedule = $vaccine->vaccination_schedule;
        $this->primary_doses = $vaccine->primary_doses;
        $this->revaccination_schedule = $vaccine->revaccination_schedule;
        $this->revaccination_doses = $vaccine->revaccination_doses;

        $this->emit('show-modal', 'show-modal');

    }

    public function update()
    {
        $this->authorize('vaccines_update');

        $rules = collect($this->validationRules)->collapse()->toArray();
        $validatedData = $this->validate($rules);

        $vaccine = Vaccine::find($this->selected_id);
        $vaccine->update($validatedData);
        $vaccine->species()->sync($this->selected_species);

        $this->resetUI();
        $this->emit('hide-modal', 'hide-modal');

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => $vaccine->name . ' information has been updated.'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('vaccines_destroy');

        $vaccine = Vaccine::findOrFail($id);

        // si esta vacuna ha sido usada en una vacunación, no se puede eliminar.
        if ($vaccine->vaccinations->count() > 0) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => $vaccine->name . 'cannot be deleted because it was applied in at least one vaccination.'
            ]);
            return;
        } else {
            //$vaccine->species()->detach($this->selected_species);
            $vaccine->delete();

            $this->dispatchBrowserEvent('updated', [
                'title' => 'Updated',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-success',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => $vaccine->name . ' has been deleted.'
            ]);
        }
    }

    public function resetUI()
    {
        $this->selected_id = '';
        $this->selected_species = [];
        $this->name = '';
        $this->type = '';
        $this->manufacturer = '';
        $this->description = '';
        $this->status = 'choose';
        $this->dosage = '';
        $this->administration = '';
        $this->vaccination_schedule = '';
        $this->primary_doses = '';
        $this->revaccination_schedule = '';
        $this->revaccination_doses = '';

        $this->currentStep = 1;

        $this->resetValidation();
        $this->resetPage();
    }
}
