<?php

namespace App\Http\Livewire;

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

    // Datatable's attributes
    public $paginate = '50', $sort = 'name', $direction = 'asc', $readyToLoad = false, $search = '';

    // General attributes
    public $pageTitle, $modalTitle;

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
        'paginate'  => ['except' => '50'],
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
            'selected_species'       => 'required',
            'name'                   => 'required|string|min:3|max:140',
            'type'                   => 'required|string|in:"Internal","External","Internal and external"',
            'manufacturer'           => 'required|string|min:3|max:140',
            'description'            => 'required|string|min:3|max:3000',
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
        $this->pageTitle = 'Parasiticides';
        $this->modalTitle = "Parasiticide";
    }

    public function render()
    {
        $this->authorize('parasiticides_index');

        if ($this->readyToLoad) {
            if (strlen($this->search) > 0) {
                $parasiticides = Parasiticide::where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('manufacturer', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            } else {
                $parasiticides = Parasiticide::orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            }
        } else {
            $parasiticides = [];
        }

        // $speciesList = Species::select('id', 'name', DB::raw("0 as checked"))
        //     ->orderBy('name')
        //     ->get();

        $speciesList = Species::select('id', 'name')
            ->orderBy('id')
            ->get();

        return view('livewire.parasiticide.component', compact('parasiticides', 'speciesList'))
            ->extends('admin.layout.app')
            ->section('content');
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

        $this->selected_id = $parasiticide->id;
        $this->selected_species = [];
        $this->target_species = $parasiticide->target_species;
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

        // si esta vacuna ha sido usada en una vacunación, no se puede eliminar.
        if ($parasiticide->dewormings->count() > 0) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => $parasiticide->name . 'cannot be deleted because it was applied in at least one deworming.'
            ]);
            return;
        } else {
            //$vaccine->species()->detach($this->selected_species);
            $parasiticide->delete();

            $this->dispatchBrowserEvent('updated', [
                'title' => 'Updated',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-success',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => $parasiticide->name . ' has been deleted.'
            ]);
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

        $this->resetValidation();
        $this->resetPage();
    }
}
