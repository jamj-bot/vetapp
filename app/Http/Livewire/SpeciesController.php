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
    public $paginate = '25',
        $sort = 'name',
        $direction = 'asc',
        $search = '',
        $readyToLoad = false,
        $selected = [],
        $deleted = [],
        $select_page = false;

    // Datatable attributes
    public $pageTitle, $modalTitle;

    // CRUD attributes
    public $name, $scientific_name, $selected_id;

    // Listener
    protected $listeners = [
        'destroy',
    ];

    // Query string to  urls with datatable filters
    protected $queryString = [
        'search'    => ['except' => ''],
        'paginate'  => ['except' => '25'],
        'sort'      => ['except' => 'name'],
        'direction' => ['except' => 'asc']
    ];

     /**
     *  Validation rules
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
     *  Check all items
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
     *  Reset $select_page and $selected properties is updated
     *
    **/
    public function updatedPaginate()
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
        // $this->select_page = false;
        // $this->selected = [];

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
            return Species::when(strlen($this->search) > 0, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('scientific_name', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);

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

            $this->resetUI();
            return;
        }

        Species::find($id)->delete();

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
    }

    public function destroyMultiple()
    {
        $this->authorize('species_destroy');

        //Si no hay items seleccionados
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

        // Eliminando del array $selected aquellos items que no se pueden borrar
        $notDeleted = [];
        foreach ($this->selected as $key => $id) {
            if (Pet::withTrashed()->where('species_id', $id)->count()) {
                array_push($notDeleted, $id);
                unset($this->selected[$key]);
            }
        }

        if ($notDeleted) {
            $notDeletedItems = Species::whereIn('id', $notDeleted)
                ->select('name')
                ->pluck('name')
                ->toArray();

            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => count($notDeletedItems) . ' items can’t be moved to Recycle bin because cannot be deleted: ' . implode(", ", $notDeletedItems)
            ]);
        }

        // Eliminando los items que sí se pueden borrar
        if ($this->selected) {
            // Agregando al array $deleted aquellos que items que sí se pueden borrar
            $this->pushDeleted();

            $deletedtems = Species::whereIn('id', $this->selected)
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
                'body' => count($deletedtems). ' items moved to Recycle bin: ' . implode(", ", $deletedtems)
            ]);
        }

        $this->resetUI();
    }

    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);

        // Restaura los ids contenidos en la última posición del array
        Species::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = Species::whereIn('id', $this->deleted[$last])
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
        $this->name = '';
        $this->scientific_name = '';

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
