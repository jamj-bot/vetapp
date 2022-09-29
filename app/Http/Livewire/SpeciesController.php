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
    public $paginate = '50',
        $sort = 'name',
        $direction = 'asc',
        $search = '',
        $readyToLoad = false,
        $selected = [],
        $select_page = false;

    // Attributes to datatable
    public $pageTitle, $modalTitle;

    // Attributes to CRUD
    public $name, $scientific_name, $selected_id;

    // Listener
    protected $listeners = [
        'destroy',
        'updatedSelected'
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
            'name' => "required|string|min:3|max:140|unique:species,name,{$this->selected_id}",
            'scientific_name' => "required|string|min:3|max:140|unique:species,scientific_name,{$this->selected_id}",
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
            $this->selected = $this->species->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->pageTitle = 'Species';
        $this->modalTitle = 'Species';
    }

    public function getSpeciesProperty()
    {
        if ($this->readyToLoad) {
            if (strlen($this->search) > 0) {
                return Species::where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('scientific_name', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            } else {
                return Species::orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            }
        } else {
            return [];
        }
    }

    public function render()
    {
        $this->authorize('species_index');

        return view('livewire.species.component', ['species' => $this->species])
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
            'body' => 'Item moved to Recycle bin.'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('species_destroy');

        if (Pet::withTrashed()->where('species_id', $id)->count()) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'Item can’t be moved to Recycle bin because cannot be deleted.'
            ]);
            return;
        }

        Species::find($id)->delete();

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Item moved to Recycle bin.'
        ]);
    }

    public function destroyMultiple()
    {
        $this->authorize('species_destroy');

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

        // Seleccionado items que no se pueden borrar
        $not_deleted = [];
        foreach ($this->selected as $key => $id) {
            if (Pet::withTrashed()->where('species_id', $id)->count()) {
                array_push($not_deleted, $id);
                unset($this->selected[$key]);
            }
        }

        // si hay items que no se pueden borrar, mando la alerta
        if ($not_deleted) {

            // Obteniendo los nombre de los items que no se pueden borrar
            $speciesNotDeleted = Species::whereIn('id', $not_deleted)
                ->select('name')
                ->pluck('name')
                ->toArray();

            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => count($speciesNotDeleted) . ' items can’t be moved to Recycle bin because cannot be deleted: ' . implode(", ", $speciesNotDeleted)
            ]);
        }

        if ($this->selected) {
            // Seleccionando los nombres de las especies que sí se pueden borrar
            $speciesDeleted = Species::whereIn('id', $this->selected)
                ->select('name')
                ->pluck('name')
                ->toArray();

            Species::destroy($this->selected);

            $this->dispatchBrowserEvent('deleted', [
                'title' => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-danger',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => count($speciesDeleted). ' items moved to Recycle bin: ' . implode(", ", $speciesDeleted)
            ]);
        }

        $this->resetUI();
    }

    function resetUI() {
        $this->selected_id = '';
        $this->name = '';
        $this->scientific_name = '';

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
