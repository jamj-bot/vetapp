<?php

namespace App\Http\Livewire\Inline;

use App\Models\Pet;
use App\Models\Species;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Pets extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Receiving parameter
    public $user;

    // Datatable attributes
    public $paginate = '50',
        $sort = 'pets.updated_at',
        $direction = 'desc',
        $search = '',
        $readyToLoad = false,
        $filter = 'Alive',
        $selected = [],
        $deleted = [],
        $select_page = false;

    // General component attrbibutes
    public $pageTitle, $modalTitle;

    // Crud Atributes
    public $selected_id,
        $species_id = 'choose',
        $code,
        $name,
        $breed,
        $zootechnical_function,
        $sex = 'choose',
        $dob,
        $estimated = 0,
        $desexed = 'choose',
        $desexing_candidate = 1,
        $alerts,
        $diseases,
        $allergies,
        $status = 'choose';

    // Listeners
    protected $listeners = [
        'refresh-pets' => 'resetUI'
    ];

    /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'species_id'            => 'required|not_in:choose',
            'code'                  => "required|numeric|digits:10|unique:pets,code,{$this->selected_id}",
            'name'                  => 'nullable|min:3|max:140',
            'breed'                 => 'nullable|max:140',
            'zootechnical_function' => 'nullable|max:140',
            'sex'                   => 'required|in:"Male", "Female", "Unknown"',
            'dob'                   => 'required|date',
            'estimated'             => 'required|boolean',
            'desexed'               => 'required|in:"Desexed", "Not desexed", "Unknown"',
            'desexing_candidate'    => 'nullable|boolean',
            'alerts'                => 'nullable|max:255',
            'diseases'              => 'nullable|max:255',
            'allergies'             => 'nullable|max:255',
            'status'                => 'required|in:"Alive","Dead"'
        ];
    }

    /**
     *  Real time validation
     *
    **/
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     *  Check or all function
     *
    **/
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->pets->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->selected = [];
        }
    }

    /**
     *  uncheck Select All
     *
    **/
    // public function updatedSelected()
    // {
    //     $this->select_page = false;
    // }

    /**
     *  uncheck Select All
     *
    **/
    public function updatedFilter()
    {
        $this->select_page = false;
        $this->selected = [];
    }

    /**
     *  Reset the pagination while search property is updated
     *  and reset select_page and selected properties is updated
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
        $this->pageTitle = 'Pets';
        $this->modalTitle = 'Pets';
    }


    public function getPetsProperty()
    {
        if ($this->readyToLoad) {
            return $this->user->pets()
                ->join('species as s', 's.id', 'pets.species_id')
                ->select('pets.id',
                    'pets.code',
                    'pets.name',
                    'pets.breed',
                    'pets.status',
                    'pets.image',
                    'pets.updated_at as updated_at',
                    's.name as common_name',
                    's.scientific_name')
                ->when($this->filter == 'Alive', function ($query) {
                    $query->where('pets.status', 'Alive');
                })
                ->when($this->filter == 'Dead', function ($query) {
                    $query->where('pets.status', 'Dead');
                })
                ->when(strlen($this->search) > 0, function ($query) {
                    $query->where('pets.code',         'like', '%' . $this->search . '%')
                        ->orWhere('pets.name',         'like', '%' . $this->search . '%')
                        ->orWhere('pets.breed',        'like', '%' . $this->search . '%')
                        ->orWhere('s.name',            'like', '%' . $this->search . '%')
                        ->orWhere('s.scientific_name', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);

        } else {
            return [];
        }
    }

    public function getSpeciesProperty()
    {
        return Species::orderBy('name', 'desc')->get();
    }


    public function render()
    {
        $this->authorize('pets_index');

        return view('livewire.inline.pets', [
            'species' => $this->species,
            'pets'    => $this->pets
        ]);
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
        $this->authorize('pets_store');

        if ($this->name == null) {
            $this->name = $this->code;
        }

        $validatedData = $this->validate();

        $this->user->pets()->create($validatedData);

        if ($this->species_id == 1) {
        }

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => '¡Pet has been stored correctly! You can find it in Pets index.'
        ]);
        $this->emit('hide-modal', 'hide-modal');
        $this->resetUI();
    }

    public function edit(Pet $pet)
    {
        $this->selected_id = $pet->id;
        $this->species_id = $pet->species_id;
        $this->code = $pet->code;
        $this->name = $pet->name;
        $this->breed = $pet->breed;
        $this->zootechnical_function = $pet->zootechnical_function;
        $this->sex = $pet->sex;
        $this->dob = $pet->dob->format('Y-m-d');
        $this->estimated = $pet->estimated;
        $this->desexed = $pet->desexed;
        $this->desexing_candidate = $pet->desexing_candidate;
        $this->alerts = $pet->alerts;
        $this->diseases = $pet->diseases;
        $this->allergies = $pet->allergies;
        $this->status = $pet->status;

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('pets_update');

        $validatedData = $this->validate();
        $pet = Pet::find($this->selected_id);
        $pet->update($validatedData);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Pet has been updated correctly.'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('pets_destroy');

        Pet::find($id)->delete();

        $this->pushDeleted($id);

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Item moved to Recycle bin.'
        ]);

        $this->resetUI();
        $this->emit('refresh-dumpster');
    }

    public function destroyMultiple()
    {
        $this->authorize('pets_destroy');

        //Si no hay ningun item seleccionado
        if (!$this->selected) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-light',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => '0 items selected'
            ]);
            return;
        }

        // Eliminando los items que sí se pueden borrar
        if ($this->selected) {
            // Agregando al array $deleted aquellos que items que sí se pueden borrar
            $this->pushDeleted();

            $deletedtems = Pet::whereIn('id', $this->selected)
                ->select('name')
                ->pluck('name')
                ->toArray();

            Pet::destroy($this->selected);

            $this->dispatchBrowserEvent('deleted', [
                'title' => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-danger',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => count($deletedtems). ' items moved to Recycle bin: ' . implode(", ", $deletedtems)
            ]);
        }

        $this->resetUI();
        $this->emit('refresh-dumpster');
    }

    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);

        // Restaura los ids contenidos en la última posición del array
        Pet::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = Pet::whereIn('id', $this->deleted[$last])
            ->select('name')
            ->pluck('name')
            ->toArray();

        $this->dispatchBrowserEvent('restored', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => count($restoredItems). ' items restored: ' . implode(", ", $restoredItems)
        ]);

        // Elimina el último elemento del array de arrays
        unset($this->deleted[$last]);

        $this->emit('refresh-dumpster');
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
        $this->species_id = 'choose';
        $this->code = '';
        $this->name = '';
        $this->breed = '';
        $this->zootechnical_function = '';
        $this->sex = 'choose';
        $this->dob = '';
        $this->estimated = 0;
        $this->desexed = 'choose';
        $this->desexing_candidate = 1;
        $this->alerts = '';
        $this->diseases = '';
        $this->allergies = '';
        $this->status = 'choose';

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
