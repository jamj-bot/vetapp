<?php

namespace App\Http\Livewire;

use App\Models\Deworming;
use App\Models\Parasiticide;
use App\Models\Species;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Dewormings extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Receiving parameter
    public $pet;

    // Datatable attributes
    public $paginate = '25',
        $sort = 'parasiticide_id',
        $direction = 'asc',
        $readyToLoad = false,
        $search = '';

    // General attrbibutes to component
    public $addButton, $modalTitle, $modalApplyTitle;

    // CRUD attributes
    public $selected_id,
        $parasiticide_id,
        $type = 'choose',
        $duration,
        $withdrawal_period,
        $dose_number,
        $doses_required;

    // public $parasiticide_name,
    //     $parasiticide_type,
    //     $parasiticide_manufacturer,
    //     $parasiticide_dose,
    //     $parasiticide_administration;

    // Attributes for modal
    public $suggested_dosage;

    // Listeners
    protected $listeners = [
        'destroyDeworming'
    ];

    /**
     * Validation rules
     *
    **/
    protected function rules()
    {
        return [
            'parasiticide_id'   => 'required|exists:parasiticides,id',
            'type'              => 'required||not_in:choose',
            'duration'          => 'required|min:3|max:140',
            'withdrawal_period' => 'nullable|min:3|max:140',
            'dose_number'       => 'required|integer|between:0,10',
            'doses_required'    => 'required|integer|between:1,10',
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
        $this->modalTitle = 'Dewormings';
        $this->modalApplyTitle = 'Deworming';
        $this->addButton = 'Register deworming';
    }

    public function render()
    {
        $this->authorize('dewormings_index');

        if ($this->readyToLoad) {
            if (strlen($this->search) > 0) {
                $dewormings = $this->pet->dewormings()
                    ->join('parasiticides as p', 'p.id', 'dewormings.parasiticide_id')
                    ->select('dewormings.id',
                        'dewormings.type',
                        'dewormings.duration',
                        'dewormings.withdrawal_period',
                        'dewormings.dose_number',
                        'dewormings.doses_required',
                        'dewormings.created_at',
                        'dewormings.updated_at',
                        'p.name as name',
                        'p.manufacturer as manufacturer',
                        'p.type as type_1',
                        'p.description as description',
                        'p.dose as dose',
                        'p.administration as administration',
                        'p.primary_application',
                        'p.primary_doses',
                        'p.reapplication_doses',
                        'p.reapplication_interval')
                    ->where('name', 'like', '%' . $this->search .'%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);

            } else {
                $dewormings = $this->pet->dewormings()
                    ->join('parasiticides as p', 'p.id', 'dewormings.parasiticide_id')
                    ->select('dewormings.id',
                        'dewormings.type',
                        'dewormings.duration',
                        'dewormings.withdrawal_period',
                        'dewormings.dose_number',
                        'dewormings.doses_required',
                        'dewormings.created_at',
                        'dewormings.updated_at',
                        'p.name as name',
                        'p.manufacturer as manufacturer',
                        'p.type as type_1',
                        'p.description as description',
                        'p.dose as dose',
                        'p.administration as administration',
                        'p.primary_application',
                        'p.primary_doses',
                        'p.reapplication_doses',
                        'p.reapplication_interval')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);

            }
        } else {
            $dewormings = [];
        }

        // $parasiticides = Parasiticide::orderBy('description', 'asc')->get();
        $parasiticides = Species::findOrFail($this->pet->species->id)->parasiticides->sortByDesc('status');

        // FOR FORM
        if ($this->parasiticide_id) {
            if ($this->type != 'choose') {
                if ($this->type == 'First application') {
                    $this->suggested_dosage = Parasiticide::find($this->parasiticide_id)->primary_doses;
                } elseif ($this->type == 'Reapplication') {
                    $this->suggested_dosage = Parasiticide::find($this->parasiticide_id)->reapplication_doses;
                }
            }
        }

        return view('livewire.dewormings', compact('parasiticides', 'dewormings'));
    }

    public function store()
    {
        $this->authorize('dewormings_store');

        $validatedData = $this->validate();

        $this->pet->dewormings()->create($validatedData);

        $this->dispatchBrowserEvent('deworming-stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Deworming has been stored correctly!.'
        ]);

        $this->resetUI();
        $this->emit('hide-modal-deworming', 'hide-modal-deworming');
    }

    public function edit(Deworming $deworming)
    {
        $this->selected_id = $deworming->id;
        $this->parasiticide_id = $deworming->parasiticide_id;
        $this->type = $deworming->type;
        $this->duration = $deworming->duration;
        $this->withdrawal_period = $deworming->withdrawal_period;
        $this->dose_number = $deworming->dose_number;
        $this->doses_required = $deworming->doses_required;

        $this->emit('show-modal-deworming', 'show-modal-deworming');
    }

    public function update()
    {
        $this->authorize('dewormings_update');

        $validatedData = $this->validate();
        $deworming = Deworming::findOrFail($this->selected_id);
        $deworming->update($validatedData);

        $this->emit('hide-modal-deworming', 'hide-modal-deworming');

        $this->resetUI();

        $this->dispatchBrowserEvent('deworming-updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Deworming has been updated correctly.'
        ]);
    }

    public function administerParasiticide(Deworming $deworming, $action)
    {
        $this->authorize('dewormings_update');

        if ($action == 'increment') {
            if ($deworming->dose_number < $deworming->doses_required) {

                $deworming->dose_number++;
                $deworming->save();

                $this->dispatchBrowserEvent('deworming-increment', [
                    'title' => 'Incremented',
                    'subtitle' => 'Succesfully!',
                    'class' => 'bg-success',
                    'icon' => 'fas fa-check-circle fa-lg',
                    'image' => auth()->user()->profile_photo_url,
                    'body' => 'Deworming has been incremented correctly.'
                ]);
            } else {
                $this->dispatchBrowserEvent('deworming-increment', [
                    'title' => 'No incremented',
                    'subtitle' => 'Error!',
                    'class' => 'bg-orange',
                    'icon' => 'fas fa-bug fa-lg',
                    'image' => auth()->user()->profile_photo_url,
                    'body' => 'It is not possible to increase the dewormings.'
                ]);
            }
        }

        if ($action == 'decrement') {
            if ($deworming->dose_number >= 0) {
                $deworming->dose_number--;
                $deworming->save();

                $this->dispatchBrowserEvent('deworming-decrement', [
                    'title' => 'Decremented',
                    'subtitle' => 'Succesfully!',
                    'class' => 'bg-danger',
                    'icon' => 'fas fa-check-circle fa-lg',
                    'image' => auth()->user()->profile_photo_url,
                    'body' => 'Deworming has been decremented correctly.'
                ]);
            } else {
                $this->dispatchBrowserEvent('deworming-increment', [
                    'title' => 'No decremented',
                    'subtitle' => 'Error!',
                    'class' => 'bg-orange',
                    'icon' => 'fas fa-bug fa-lg',
                    'image' => auth()->user()->profile_photo_url,
                    'body' => 'It is not possible to decrease the dewormings.'
                ]);
            }
        }
    }

    public function destroyDeworming(Deworming $deworming)
    {
        $this->authorize('vaccinations_destroy');

        $deworming->delete();

        $this->dispatchBrowserEvent('deworming-deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Deworming has been deleted correctly.'
        ]);
    }

    public function resetUI()
    {
        // CRUD attributes
        $this->selected_id = '';
        $this->parasiticide_id = null;
        $this->type = 'choose';
        $this->duration = '';
        $this->withdrawal_period = '';
        $this->dose_number = '';
        $this->doses_required = null;
        $this->resetValidation();

        // Other attributes
        $this->parasiticide_name = '';
        $this->parasiticide_type = '';
        $this->parasiticide_manufacturer = '';
        $this->parasiticide_dose = '';
        $this->parasiticide_administration = '';
    }
}
