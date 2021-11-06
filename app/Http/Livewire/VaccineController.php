<?php

namespace App\Http\Livewire;

use App\Models\Species;
use App\Models\Vaccination;
use App\Models\Vaccine;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VaccineController extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Datatable attributes
    public $paginate = '50', $sort = 'name', $direction = 'asc', $readyToLoad = false, $search = '';

    // General attributes
    public $pageTitle, $modalTitle;

    // CRUD attributes
    public  $selected_species = [],
            $target_species,
            $name,
            $type,
            $manufacturer,
            $description,
            $dose,
            $administration,
            $primary_vaccination,
            $primary_doses,
            $revaccination_interval,
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
        'paginate'  => ['except' => '50'],
        'sort'      => ['except' => 'name'],
        'direction' => ['except' => 'asc']
    ];

    /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules() {
        return [
            'target_species'         => 'required|string|min:3|max:140',
            'name'                   => 'required|string|min:3|max:140',
            'type'                   => 'required|string|min:3|max:140',
            'manufacturer'           => 'required|string|min:3|max:140',
            'description'            => 'required|string|min:3|max:3000',
            'dose'                   => 'required|string|min:3|max:255',
            'administration'         => 'required|string|min:3|max:255',
            'primary_vaccination'    => 'required|string|min:3|max:255',
            'primary_doses'          => 'required|integer|between:1,10',
            'revaccination_interval' => 'required|string|min:3|max:255',
            'revaccination_doses'    => 'required|integer|between:0,10'
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
        $this->pageTitle = 'Vaccines';
        $this->modalTitle = "Vaccine";
    }

    public function render()
    {
        $this->authorize('vaccines_index');

        // $vaccine = Vaccine::find(1);
        // $vaccine->species;

        if ($this->readyToLoad) {
            if (strlen($this->search) > 0 ) {
                $vaccines = Vaccine::where('target_species', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('manufacturer', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);

            } else {
                $vaccines = Vaccine::orderBy($this->sort, $this->direction)->paginate($this->paginate);
            }
        } else {
            $vaccines = [];
        }

        $speciesList = Species::select('id', 'name', DB::raw("0 as checked"))
            ->orderBy('name')
            ->get();

        return view('livewire.vaccine.component', compact('vaccines', 'speciesList'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function store()
    {
        //dd($this->selected_species);
        $this->authorize('vaccines_store');
        $validatedData = $this->validate();
        $vaccine = Vaccine::create($validatedData);

        //$this->selected_species = Species::pluck('id')->toArray();
        $vaccine->species()->attach($this->selected_species);

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
        //$ids = $vaccine->species->pluck('id');
        $this->selected_id = $vaccine->id;
        //$this->selected_species = $vaccine->species->pluck('id');
        $this->selected_species = [];
        $this->target_species = $vaccine->target_species;
        $this->name = $vaccine->name;
        $this->type = $vaccine->type;
        $this->manufacturer = $vaccine->manufacturer;
        $this->description = $vaccine->description;
        $this->dose = $vaccine->dose;
        $this->administration = $vaccine->administration;
        $this->primary_vaccination = $vaccine->primary_vaccination;
        $this->primary_doses = $vaccine->primary_doses;
        $this->revaccination_interval = $vaccine->revaccination_interval;
        $this->revaccination_doses = $vaccine->revaccination_doses;

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('vaccines_update');
        //dd($this->selected_species);

        $validatedData = $this->validate();
        $vaccine = Vaccine::find($this->selected_id);
        $vaccine->update($validatedData);

        $vaccine->species()->sync($this->selected_species);

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
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => $vaccine->name . 'cannot be deleted because it was applied in at least one vaccination.'
            ]);
            return;
        } else {
            //$vaccine->species()->detach($this->selected_species);
            $vaccine->delete();

            $this->dispatchBrowserEvent('updated', [
                'title' => 'Updated',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-success',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => $vaccine->name . ' has been deleted.'
            ]);
        }
    }

    public function resetUI()
    {
        $this->selected_id = '';
        $this->selected_species = [];
        $this->target_species = '';
        $this->name = '';
        $this->type = '';
        $this->manufacturer = '';
        $this->description = '';
        $this->dose = '';
        $this->administration = '';
        $this->primary_vaccination = '';
        $this->primary_doses = '';
        $this->revaccination_interval = '';
        $this->revaccination_doses = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
