<?php

namespace App\Http\Livewire;

use App\Models\Species;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class StorePets extends Component
{
    use AuthorizesRequests;

    public $user;

    // Attributes to create model instances
    public $species_id, $code, $name, $breed, $sex, $dob, $neutered, $diseases, $allergies, $status;

    /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'species_id' => 'required|not_in:choose',
            'code' => "required|numeric|digits:10|unique:pets,code",
            'name' => 'required|min:3|max:140',
            'breed' => 'nullable|max:140',
            'sex' => 'required|in:"Male","Female","Unknown"',
            'dob' => 'required|date',
            'neutered' => 'required|in:"Yes", "No", "Unknown',
            'diseases' => 'nullable|max:2000',
            'allergies' => 'nullable|max:2000',
            'status' => 'required|in:"Alive","Dead"'
        ];
    }

    public function render()
    {
        $species = Species::orderBy('name', 'desc')->get();

        return view('livewire.store-pets', compact('species'));
    }

    /**
     *  Real time validation
     *
    **/
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function store()
    {
        //$this->authorize('store_pets')

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
        $this->emit('refresh-index-pets');
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->species_id = 'choose';
        $this->code = '';
        $this->name = '';
        $this->breed = '';
        $this->sex = 'choose';
        $this->dob = '';
        $this->neutered = 'choose';
        $this->diseases = '';
        $this->allergies = '';
        $this->status = 'choose';
        $this->resetValidation();
    }
}
