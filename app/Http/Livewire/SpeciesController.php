<?php

namespace App\Http\Livewire;

use App\Models\Pet;
use App\Models\Species;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class SpeciesController extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Attributes to datatable
    public $paginate = '10', $sort = 'name', $direction = 'asc', $search = '';

    // Attributes to datatable
    public $pageTitle, $modalTitle;

    // Attributes to CRUD
    public $name, $scientific_name, $selected_id;

    // Listener
    protected $listeners = [
        'destroy'
    ];

    // Query string to  urls with datatable filters
    protected $queryString = [
        'search' => ['except' => ''],
        'paginate' => ['except' => '10'],
        'sort' => ['except' => 'name'],
        'direction' => ['except' => 'asc']
    ];

     /**
     *  Function that returns the validation rules
     *
    **/
     protected function rules()
     {
         return [
            'name' => "required|string|max:140|unique:species,name,{$this->selected_id}",
            'scientific_name' => "required|string|max:140|unique:species,scientific_name,{$this->selected_id}",
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

    public function mount()
    {
        $this->pageTitle = 'Species';
        $this->modalTitle = 'Species';
    }

    public function render()
    {
        $this->authorize('species_index');

        if (strlen($this->search) > 0) {
            $species = Species::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('scientific_name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        } else {
            $species = Species::orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        }

        return view('livewire.species.component', compact('species'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function store()
    {
        $this->authorize('species_store');

        $validatedData = $this->validate();
        Species::create($validatedData);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Species has been stored correctly! You can find it in the species list.'
        ]);
    }

    public function edit(Species $species)
    {
        $this->selected_id = $species->id;
        $this->name = $species->name;
        $this->scientific_name = $species->scientific_name;

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('species_update');

        $validatedData = $this->validate();
        $species = Species::find($this->selected_id);
        $species->update($validatedData);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Species has been updated correctly.'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('species_destroy');

        $petsCount = Pet::where('species_id', $id)->count();

        if ($petsCount > 0) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'This Species cannot be removed because has associated Pets.'
            ]);
            return;
        }

        Species::find($id)->delete();
    }

    function resetUI() {
        $this->selected_id = '';
        $this->name = '';
        $this->scientific_name = '';
        $this->resetValidation();
        $this->resetPage();
    }
}
