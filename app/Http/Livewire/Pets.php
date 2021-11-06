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

    // Receiving parameter
    public $user;

    // Datatable attributes
    public $paginate = '50', $sort = 'pets.id', $direction = 'desc', $readyToLoad = false, $search = '', $filter = 'Alive';

    // General component attrbibutes
    public $modalTitle;

    // Crude Atributes
    public $selected_id, $species_id, $code, $name, $breed, $zootechnical_function, $sex, $dob, $neuteredOrSpayed, $diseases, $allergies, $status;

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
            'name'                  => 'required|min:3|max:140',
            'breed'                 => 'nullable|max:140',
            'zootechnical_function' => 'nullable|max:140',
            'sex'                   => 'required|in:"Male","Female","Unknown"',
            'dob'                   => 'required|date',
            'neuteredOrSpayed'      => 'required|in:"Neutered or spayed", "Not neutered or spayed", "Unknown neutered or spayed status"',
            'diseases'              => 'nullable|max:2000',
            'allergies'             => 'nullable|max:2000',
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
        $this->modalTitle = 'Pets';
    }


    public function render()
    {
        $this->authorize('pets_index');

        if ($this->readyToLoad) {
            if (strlen($this->search) > 0) {

                $pets = $this->user->pets()
                    ->join('species as s', 's.id', 'pets.species_id')
                    ->select('pets.id', 'pets.code', 'pets.name', 'pets.breed', 'pets.status', 's.name as common_name', 's.scientific_name')
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

                // $pets = $this->user->pets()->where('status', $this->filter)
                //     ->where(function($query){
                //         $query->where('code' , 'like', '%' . $this->search . '%')
                //             ->orWhere('name' , 'like', '%' . $this->search . '%')
                //             ->orWhere('status' , 'like', '%' . $this->search . '%')
                //             ->orWhere('species_id' , 'like', '%' . $this->search . '%');
                //     })
                //     ->orderBy($this->sort, $this->direction)
                //     ->paginate($this->paginate);
            } else {
                 // $pets = $this->user->pets()->where('status', $this->filter)
                 //    ->orderBy($this->sort, $this->direction)
                 //    ->simplePaginate($this->paginate);


                $pets = $this->user->pets()
                    ->join('species as s', 's.id', 'pets.species_id')
                    ->select('pets.id', 'pets.code', 'pets.name', 'pets.breed', 'pets.status', 's.name as common_name', 's.scientific_name')
                    ->where('pets.status', $this->filter)
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            }
        } else {
            $pets = [];
        }

        $species = Species::orderBy('name', 'desc')->get();

        return view('livewire.pets', compact('pets', 'species'));
    }

    public function store()
    {
        $this->authorize('pets_store');

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
        $this->neuteredOrSpayed = $pet->neuteredOrSpayed;
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
        //$this->authorize('vaccinations_destroy');

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
        $this->neuteredOrSpayed = 'choose';
        $this->diseases = '';
        $this->allergies = '';
        $this->status = 'choose';
        $this->resetValidation();
    }
}
