<?php

namespace App\Http\Livewire;

use App\Models\Disease;
use App\Models\Species;
use App\Models\Vaccination;
use App\Models\Vaccine;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class VaccineController extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Datatable attributes
    public $paginate = '25',
        $sort        = 'name',
        $direction   = 'asc',
        $search      = '',
        $readyToLoad = false,
        $selected    = [],
        $deleted     = [],
        $select_page = false;

    // General attributes
    public $pageTitle, $modalTitle;

    // Stepper
    public $totalSteps = 4, $currentStep = 1;
    public $steps = [
        1 => [
            'heading'    => 'Information',
        ],
        2 => [
            'heading'    => 'Species',
        ],
        3 => [
            'heading'    => 'Usage',
        ],
        4 => [
            'heading'    => 'Save',
        ]
    ];

    // CRUD attributes
    public $selected_species = [],
        $name,
        $type,
        $manufacturer,
        $disease,
        $description,
        $status = 'choose',
        $dosage,
        $administration,
        $vaccination_schedule,
        $vaccination_doses,
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
        'paginate'  => ['except' => '25'],
        'sort'      => ['except' => 'name'],
        'direction' => ['except' => 'asc']
    ];

    /**
     *  Validation rules by steps (for stepper)
     *
     **/
    // protected $validationRules = [
    //     1 => [
    //         'name'         => ['required', 'string', 'min:3', 'max:140'],
    //         'type'         => ['required', 'string', 'min:3', 'max:140'],
    //         'manufacturer' => ['required', 'string', 'min:3', 'max:140'],
    //         'description'  => ['required', 'string', 'min:3', 'max:3000'],
    //         'status'       => ['required', 'in:"Required", "Recommended", "Optional"'],
    //     ],
    //     2 => [
    //         'selected_species' => ['required', 'array'],
    //     ],
    //     3 => [
    //         'dosage'                 => ['required', 'string', 'min:3', 'max:255'],
    //         'administration'         => ['required', 'string', 'min:3', 'max:255'],
    //         'vaccination_schedule'   => ['required', 'string', 'min:3', 'max:255'],
    //         'vaccination_doses'      => ['required', 'integer', 'integer', 'between:1,10'],
    //         'revaccination_schedule' => ['required', 'string', 'min:3', 'max:255'],
    //         'revaccination_doses'    => ['required', 'integer', 'integer', 'between:0,10'],
    //     ]
    // ];

     /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'name'                   => "required|string|min:3|max:140|unique:vaccines,name,{$this->selected_id}",
            'type'                   => 'required|string|min:3|max:140',
            'manufacturer'           => 'required|string|min:3|max:140',
            'disease'                => 'required|max:255',
            'description'            => 'required|string|min:3|max:3000',
            'status'                 => 'required|in:"Required", "Recommended", "Optional"',
            'selected_species'       => 'required|array',
            'dosage'                 => 'required|string|min:3|max:255',
            'administration'         => 'required|string|min:3|max:255',
            'vaccination_schedule'   => 'required|string|min:3|max:255',
            'vaccination_doses'      => 'required|integer|integer|between:1,10',
            'revaccination_schedule' => 'nullable|string|min:3|max:255',
            'revaccination_doses'    => 'nullable|integer|integer|between:1,10',
        ];
    }

    /**
     *  Real time validation
     'name' =>
     *
    **/
    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName, $this->validationRules[$this->currentStep]);
    // }


    public function updated($propertyName)
    {
        if ($this->currentStep == 1) {
            $this->validateOnly($propertyName, [
                'name'         => "required|string|min:3|max:140|unique:vaccines,name,{$this->selected_id}",
                'type'         => 'required|string|min:3|max:140',
                'manufacturer' => 'required|string|min:3|max:140',
                'disease'      => 'required|max:255',
                'description'  => 'required|string|min:3|max:3000',
                'status'       => 'required|in:"Required", "Recommended", "Optional"',
            ]);
        }

        if ($this->currentStep == 2) {
            $this->validateOnly($propertyName, [
                'selected_species' => 'required|array',
            ]);
        }

        if ($this->currentStep == 3) {
            $this->validateOnly($propertyName, [
                'dosage'                 => 'required|string|min:3|max:255',
                'administration'         => 'required|string|min:3|max:255',
                'vaccination_schedule'   => 'required|string|min:3|max:255',
                'vaccination_doses'      => 'required|integer|integer|between:1,10',
                'revaccination_schedule' => 'nullable|string|min:3|max:255',
                'revaccination_doses'    => 'nullable|integer|integer|between:1,10',
            ]);
        }
    }

    public function goToNextStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $this->totalSteps;
        }

    }

    public function goToPreviousStep()
    {
        $this->resetErrorBag();
        $this->currentStep--;
        if ($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }

    /**
     *  Check all items
     *
    **/
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->vaccines->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->selected = [];
        }
    }

    /**
     *  Reset $select_page and $selected properties is updated
     *
    **/
    public function updatedPaginate()
    {
        $this->select_page = false;
        $this->selected = [];
    }

    /**
     *  Funtion to reset pagination when a user writtes in search field
     *
    **/
    public function updatingSearch()
    {
        $this->resetPage();

        // Al escribir en el buscador, se limpian los items seleccionados
        $this->select_page = false;
        $this->selected = [];
    }

    /**
     *  Funtion to reset pagination when a filter changes
     *
    **/
    public function resetPagination()
    {
        $this->resetPage();
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
        $this->currentStep = 1;
        $this->pageTitle = 'Vaccines';
        $this->modalTitle = "Vaccine";
    }

    public function getVaccinesProperty()
    {
        if ($this->readyToLoad) {
            return Vaccine::with(['species:name', 'diseases:name'])
                ->when(strlen($this->search) > 0, function ($query) {
                    $query->where('name', 'like', '%' . $this->search .'%')
                    ->orWhere('manufacturer', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('administration', 'like', '%' . $this->search . '%')
                    ->orWhereHas('diseases', function ($query) {
                         $query->where('name', 'like', '%'. $this->search .'%');
                    })
                    ->orWhereHas('species', function ($query) {
                         $query->where('name', 'like', '%'. $this->search .'%');
                    });
                })->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        } else {
            return [];
        }
    }


    public function render()
    {
        $this->authorize('vaccines_index');

        $speciesList = Species::select('id', 'name', 'scientific_name')
            ->orderBy('name')
            ->get();


        $this->dispatchBrowserEvent('rendered');

        return view('livewire.vaccine.component', ['vaccines' => $this->vaccines, 'speciesList' => $speciesList])
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function validateData()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'name'         => "required|string|min:3|max:140|unique:vaccines,name,{$this->selected_id}",
                'type'         => 'required|string|min:3|max:140',
                'manufacturer' => 'required|string|min:3|max:140',
                'disease'      => 'required|max:255',
                'description'  => 'required|string|min:3|max:3000',
                'status'       => 'required|in:"Required", "Recommended", "Optional"',
            ]);
        }

        if ($this->currentStep == 2) {
            $this->validate([
                'selected_species' => 'required|array',
            ]);
        }

        if ($this->currentStep == 3) {
            $this->validate([
                'dosage'                 => 'required|string|min:3|max:255',
                'administration'         => 'required|string|min:3|max:255',
                'vaccination_schedule'   => 'required|string|min:3|max:255',
                'vaccination_doses'      => 'required|integer|integer|between:1,10',
                'revaccination_schedule' => 'nullable|string|min:3|max:255',
                'revaccination_doses'    => 'nullable|integer|integer|between:1,10',
            ]);
        }
    }

    public function submit()
    {
        if ($this->selected_id) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->authorize('vaccines_store');

        // Usando validation rules by steps
            // $rules = collect($this->validationRules)->collapse()->toArray();
            // $validatedData = $this->validate($rules);

        $validatedData = $this->validate();

        $vaccine = Vaccine::create($validatedData);
        $vaccine->species()->attach($this->selected_species);

        // String disease, se convierte en
        foreach(explode("; ", $this->disease) as $disease)
        {
            $diseases[] = Disease::firstOrCreate(['name' => Str::of($disease)->trim()])->id;
        }
        $vaccine->diseases()->attach($diseases);

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
        // Recupera el array de ids de especies seleccionadas con formato de string
        $this->selected_species = $vaccine->species->pluck('id')->map(fn ($item) => (string) $item)->toArray();

        $this->selected_id = $vaccine->id;
        $this->name = $vaccine->name;
        $this->type = $vaccine->type;
        $this->manufacturer = $vaccine->manufacturer;
        $this->disease = Str::ucfirst($vaccine->diseases->implode('name', '; '));
        $this->description = $vaccine->description;
        $this->status = $vaccine->status;
        $this->dosage = $vaccine->dosage;
        $this->administration = $vaccine->administration;
        $this->vaccination_schedule = $vaccine->vaccination_schedule;
        $this->vaccination_doses = $vaccine->vaccination_doses;
        $this->revaccination_schedule = $vaccine->revaccination_schedule;
        $this->revaccination_doses = $vaccine->revaccination_doses;

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('vaccines_update');

        $validatedData = $this->validate();

        $vaccine = Vaccine::find($this->selected_id);
        $vaccine->update($validatedData);
        $vaccine->species()->sync($this->selected_species);

        // String disease, se convierte en
        foreach(explode("; ", $this->disease) as $disease)
        {
            $diseases[] = Disease::firstOrCreate(['name' => Str::of($disease)->trim()])->id;
        }
        $vaccine->diseases()->sync($diseases);

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
                'title'    => 'Not deleted',
                'subtitle' => 'Warning!',
                'class'    => 'bg-warning',
                'icon'     => 'fas fa-exclamation-triangle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => $vaccine->name . 'cannot be deleted because it was applied in at least one vaccination.'
            ]);
            return;
        }

        //$vaccine->species()->detach($this->selected_species);
        $vaccine->delete();

        $this->pushDeleted($id);

        $this->dispatchBrowserEvent('updated', [
            'title'    => 'Updated',
            'subtitle' => 'Succesfully!',
            'class'    => 'bg-success',
            'icon'     => 'fas fa-check-circle fa-lg',
            'image'    => auth()->user()->profile_photo_url,
            'body'     => $vaccine->name . ' has been deleted.'
        ]);

        $this->resetUI();
    }

    public function destroyMultiple()
    {
        $this->authorize('vaccines_destroy');

        //Si no hay items seleccionados
        if (!$this->selected) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title'    => 'Not deleted',
                'subtitle' => 'Warning!',
                'class'    => 'bg-light',
                'icon'     => 'fas fa-exclamation-triangle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => '0 items selected'
            ]);
            return;
        }

        // Elimina del $selected[] aquellas vacunas que no se pueden borrar porque se usaron en al menos una vacunación.
        $notDeleted = [];
        foreach ($this->selected as $key => $id) {
            if (Vaccination::withTrashed()->where('vaccine_id', $id)->count()) {
                array_push($notDeleted, $id);
                unset($this->selected[$key]);
            }
        }

        if ($notDeleted) {
            $notDeletedItems = Vaccine::whereIn('id', $notDeleted)
                ->select('name')
                ->pluck('name')
                ->toArray();

            $this->dispatchBrowserEvent('destroy-error', [
                'title'    => 'Not deleted',
                'subtitle' => 'Warning!',
                'class'    => 'bg-warning',
                'icon'     => 'fas fa-exclamation-triangle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => count($notDeletedItems) . ' items can’t be moved to Recycle bin because cannot be deleted: ' . implode(", ", $notDeletedItems)
            ]);
        }

        // Eliminando los items que sí se pueden borrar
        if ($this->selected) {
            // Agregando al array $deleted aquellos que items que sí se pueden borrar
            $this->pushDeleted();

            $deletedtems = Vaccine::whereIn('id', $this->selected)
                ->select('name')
                ->pluck('name')
                ->toArray();

            Vaccine::destroy($this->selected);

            $this->dispatchBrowserEvent('deleted', [
                'title'    => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class'    => 'bg-danger',
                'icon'     => 'fas fa-check-circle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => count($deletedtems). ' items moved to Recycle bin: ' . implode(", ", $deletedtems)
            ]);
        }

        $this->resetUI();
    }

    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);


        // Restaura los ids contenidos en la última posición del array
        Vaccine::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = Vaccine::whereIn('id', $this->deleted[$last])
            ->select('name')
            ->pluck('name')
            ->toArray();

        $this->dispatchBrowserEvent('restored', [
            'title'    => 'Restored',
            'subtitle' => 'Succesfully!',
            'class'    => 'bg-success',
            'icon'     => 'fas fa-check-circle fa-lg',
            'image'    => auth()->user()->profile_photo_url,
            'body'     => count($restoredItems). ' items restored: ' . implode(", ", $restoredItems)
        ]);

        // Elimina el último elemento del array de arrays
        unset($this->deleted[$last]);
    }

    /**
     * Inserta un nuevo array de ids en el array $deleted;
     *
    **/
    public function pushDeleted($id = null)
    {
        if ($id) {
            $this->selected = [$id];
        }

        if (count($this->deleted) < 10) {
            array_push($this->deleted, $this->selected);
        } elseif (count($this->deleted) == 10) {
            unset($this->deleted[0]);
            array_push($this->deleted, $this->selected);
        }
    }

    public function resetUI()
    {
        $this->selected_id = null;
        $this->selected_species = [];
        $this->name = '';
        $this->type = '';
        $this->manufacturer = '';
        $this->disease = '';
        $this->description = '';
        $this->status = 'choose';
        $this->dosage = '';
        $this->administration = '';
        $this->vaccination_schedule = '';
        $this->vaccination_doses = '';
        $this->revaccination_schedule = '';
        $this->revaccination_doses = '';

        $this->currentStep = 1;

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
