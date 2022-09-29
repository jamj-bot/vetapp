<?php

namespace App\Http\Livewire;

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

    // Parameter
    public $user;

    // Datatable attributes
    public $paginate = '50',
        $sort = 'pets.updated_at',
        $direction = 'desc',
        $search = '',
        $readyToLoad = false,
        $filter = 'Alive',
        $selected = [],
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
        'destroy'
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
    public function updatedSelected()
    {
        $this->select_page = false;
    }

    /**
     *  uncheck Select All
     *
    **/
    public function updatedFilter()
    {
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
        $this->pageTitle = 'Pets';
        $this->modalTitle = 'Pets';
    }


    public function getPetsProperty()
    {
        if ($this->readyToLoad) {
            if (strlen($this->search) > 0) {
                return $this->user->pets()
                    ->join('species as s', 's.id', 'pets.species_id')
                    ->select('pets.id',
                        'pets.code',
                        'pets.name',
                        'pets.breed',
                        'pets.status',
                        'pets.updated_at as updated_at',
                        's.name as common_name',
                        's.scientific_name')
                    ->where('status', $this->filter)
                    ->where(function($query){
                        $query->where('pets.code' , 'like', '%' . $this->search . '%')
                            ->orWhere('pets.name' , 'like', '%' . $this->search . '%')
                            ->orWhere('pets.breed' , 'like', '%' . $this->search . '%')
                            ->orWhere('pets.status' , 'like', '%' . $this->search . '%')
                            ->orWhere('s.name' , 'like', '%' . $this->search . '%')
                            ->orWhere('s.scientific_name' , 'like', '%' . $this->search . '%');
                    })
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            } else {
                return $this->user->pets()
                    ->join('species as s', 's.id', 'pets.species_id')
                    ->select('pets.id', 'pets.code', 'pets.name', 'pets.breed', 'pets.status', 's.name as common_name', 's.scientific_name')
                    ->where('pets.status', $this->filter)
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            }
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

    public function store()
    {
        $this->authorize('pets_store');

        if ($this->name == null) {
            $this->name = $this->code;
        }

        $validatedData = $this->validate();

        $this->user->pets()->create($validatedData);

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

    public function destroy(Pet $pet)
    {
        $this->authorize('pets_destroy');

        $pet->delete();

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Pet has been deleted correctly.'
        ]);
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

        if ($this->selected) {
            // Seleccionando los nombres de las especies que sí se pueden borrar
            $petsDeleted = Pet::whereIn('id', $this->selected)
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
                'body' => count($petsDeleted). ' items moved to Recycle bin: ' . implode(", ", $petsDeleted)
            ]);
        }

        $this->resetUI();
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
