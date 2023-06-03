<?php

namespace App\Http\Livewire;

use App\Models\Deworming;
use App\Models\Species;
use App\Models\Parasiticide;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ParasiticideController extends Component
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

    // Crude attributes
    public $selected_species = [],
        $name,
        $type = 'choose',
        $manufacturer,
        $description,
        $dose,
        $administration,
        $primary_application,
        $primary_doses,
        $reapplication_interval,
        $reapplication_doses,
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
     *  Function that returns the validation rules
     *
    **/

    protected function rules()
    {
        return [
            'name'                   => "required|string|min:3|max:140|unique:parasiticides,name,{$this->selected_id}", // es posible que deba quitar la regla UNIQUE
            'type'                   => 'required|string|in:"Internal","External","Internal and external"',
            'manufacturer'           => 'required|string|min:3|max:140',
            'description'            => 'required|string|min:3|max:3000',
            'selected_species'       => 'required|array',
            'dose'                   => 'required|string|min:3|max:255',
            'administration'         => 'required|string|min:3|max:255',
            'primary_application'    => 'required|string|min:3|max:255',
            'primary_doses'          => 'required|integer|integer:between:1,10',
            'reapplication_interval' => 'required|string|min:3|max:255',
            'reapplication_doses'    => 'required|integer|integer:between:0,10'
        ];
    }


    /**
     *  Real time validation
     *
    **/
    public function updated($propertyName)
    {
        if ($this->currentStep == 1) {
            $this->validateOnly($propertyName, [
                'name'         => "required|string|min:3|max:140|unique:parasiticides,name,{$this->selected_id}",
                'type'         => 'required|string|in:"Internal","External","Internal and external"',
                'manufacturer' => 'required|string|min:3|max:140',
                'description'  => 'required|string|min:3|max:3000',
            ]);
        }

        if ($this->currentStep == 2) {
            $this->validateOnly($propertyName, [
                'selected_species' => 'required|array',
            ]);
        }

        if ($this->currentStep == 3) {
            $this->validateOnly($propertyName, [
                'dose'                   => 'required|string|min:3|max:255',
                'administration'         => 'required|string|min:3|max:255',
                'primary_application'    => 'required|string|min:3|max:255',
                'primary_doses'          => 'required|integer|integer:between:1,10',
                'reapplication_interval' => 'required|string|min:3|max:255',
                'reapplication_doses'    => 'required|integer|integer:between:0,10'
            ]);
        }
    }

    /**
     *  Check all items
     *
    **/
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->parasiticides->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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

    public function goToNextStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $$this->totalSteps;
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
        $this->currentStep = 1;
        $this->readyToLoad = true;
    }

    public function mount()
    {
        $this->pageTitle = 'Parasiticides';
        $this->modalTitle = "Parasiticide";
    }

    public function getParasiticidesProperty()
    {
        if ($this->readyToLoad) {
            return Parasiticide::with(['species:name'])
                ->when(strlen($this->search) > 0, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('manufacturer', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('species', function ($query) {
                        $query->where('name', 'like', '%'. $this->search .'%');
                    });
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        } else {
            return [];
        }
    }

    public function render()
    {
        $this->authorize('parasiticides_index');

        $speciesList = Species::select('id', 'name', 'scientific_name')
            ->orderBy('name')
            ->get();

        return view('livewire.parasiticide.component',['parasiticides' => $this->parasiticides, 'speciesList' => $speciesList])
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function validateData()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'name'         => "required|string|min:3|max:140|unique:parasiticides,name,{$this->selected_id}",
                'type'         => 'required|string|in:"Internal","External","Internal and external"',
                'manufacturer' => 'required|string|min:3|max:140',
                'description'  => 'required|string|min:3|max:3000',
            ]);
        }

        if ($this->currentStep == 2) {
            $this->validate([
                'selected_species' => 'required|array',
            ]);
        }

        if ($this->currentStep == 3) {
            $this->validate([
                'dose'                   => 'required|string|min:3|max:255',
                'administration'         => 'required|string|min:3|max:255',
                'primary_application'    => 'required|string|min:3|max:255',
                'primary_doses'          => 'required|integer|integer:between:1,10',
                'reapplication_interval' => 'required|string|min:3|max:255',
                'reapplication_doses'    => 'required|integer|integer:between:0,10'
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
        $this->authorize('parasiticides_store');

        $validatedData = $this->validate();

        $parasiticide = Parasiticide::create($validatedData);
        $parasiticide->species()->attach($this->selected_species);

        $this->emit('hide-modal', 'hide-modal');
        $this->resetUI();

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => $parasiticide->name . ' has been stored.'
        ]);
    }

    public function edit(Parasiticide $parasiticide)
    {
        $this->authorize('parasiticides_update');

        // Recupera el array de ids de especies seleccionadas con formato de string
        $this->selected_species = $parasiticide->species->pluck('id')->map(fn ($item) => (string) $item)->toArray();

        $this->selected_id = $parasiticide->id;
        $this->name = $parasiticide->name;
        $this->type = $parasiticide->type;
        $this->manufacturer = $parasiticide->manufacturer;
        $this->description = $parasiticide->description;
        $this->dose = $parasiticide->dose;
        $this->administration = $parasiticide->administration;
        $this->primary_application = $parasiticide->primary_application;
        $this->primary_doses = $parasiticide->primary_doses;
        $this->reapplication_interval = $parasiticide->reapplication_interval;
        $this->reapplication_doses = $parasiticide->reapplication_doses;

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('parasiticides_update');

        $validatedData = $this->validate();

        $parasiticide = Parasiticide::find($this->selected_id);
        $parasiticide->update($validatedData);
        $parasiticide->species()->sync($this->selected_species);

        $this->resetUI();
        $this->emit('hide-modal', 'hide-modal');

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => $parasiticide->name . ' information has been updated.'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('parasiticides_destroy');

        $parasiticide = Parasiticide::findOrFail($id);

        // si esta desparasitante ha sido usada en una desparasitación, no se puede eliminar.
        if ($parasiticide->dewormings->count() > 0) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title'    => 'Not deleted',
                'subtitle' => 'Warning!',
                'class'    => 'bg-warning',
                'icon'     => 'fas fa-exclamation-triangle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => $parasiticide->name . 'cannot be deleted because it was applied in at least one vaccination.'
            ]);
            return;
        }

        //$vaccine->species()->detach($this->selected_species);
        $parasiticide->delete();

        $this->pushDeleted($id);

        $this->dispatchBrowserEvent('updated', [
            'title'    => 'Updated',
            'subtitle' => 'Succesfully!',
            'class'    => 'bg-success',
            'icon'     => 'fas fa-check-circle fa-lg',
            'image'    => auth()->user()->profile_photo_url,
            'body'     => $parasiticide->name . ' has been deleted.'
        ]);

        $this->resetUI();
    }

    public function destroyMultiple()
    {
        $this->authorize('parasiticides_destroy');

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
            if (Deworming::withTrashed()->where('parasiticide_id', $id)->count()) {
                array_push($notDeleted, $id);
                unset($this->selected[$key]);
            }
        }

        if ($notDeleted) {
            $notDeletedItems = Parasiticide::whereIn('id', $notDeleted)
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

            $deletedtems = Parasiticide::whereIn('id', $this->selected)
                ->select('name')
                ->pluck('name')
                ->toArray();

            Parasiticide::destroy($this->selected);

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
        Parasiticide::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = Parasiticide::whereIn('id', $this->deleted[$last])
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
        $this->selected_id = '';
        $this->selected_species = [];
        $this->target_species = '';
        $this->name = '';
        $this->type = 'choose';
        $this->manufacturer = '';
        $this->description = '';
        $this->dose = '';
        $this->administration = '';
        $this->primary_application = '';
        $this->primary_doses = null;
        $this->reapplication_interval = '';
        $this->reapplication_doses = null;

        $this->currentStep = 1;

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
