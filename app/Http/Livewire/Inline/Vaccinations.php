<?php

namespace App\Http\Livewire\Inline;

use App\Models\Pet;
use App\Models\Species;
use App\Models\Vaccination;
use App\Models\Vaccine;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Vaccinations extends Component
{
	use AuthorizesRequests;
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

	// Receiving parameter
	public $pet;

	// Datatable attributes
	public $paginate = '25',
		$sort = 'done',
		$direction = 'desc',
		$search = '',
		$readyToLoad = false,
		$selected = [],
        $deleted = [],
        $select_page = false;


	// General attrbibutes to component
	public $modalTitle, $pageTitle, $modalApplyTitle;

	// CRUD attributes
	public $selected_id,
	$vaccine_id,
	$type = 'choose',
	$batch_number,
	$dose_number,
	$doses_required,
	$done,
	$applied = null;

	// Attributes for modal
	public $suggested_doses = 1;

	// Listeners
	protected $listeners = [
		'destroy'
	];

	/**
	 *  Function that returns the validation rules |regex:/([a-zA-Z0-9]{3})([-. ]?)([a-zA-Z0-9]{2})([-. ]?)([a-zA-Z0-9]{4})/
	 *
	**/
	protected function rules()
	{
		return [
			'vaccine_id'     => 'required|exists:vaccines,id',
			'type'           => 'required|not_in:choose',
			'dose_number'    => 'required|integer|between:1,5',
			'doses_required' => 'required|integer|between:1,5',
			'done'           => 'required|date',
			'applied'        => 'required|boolean',
			'batch_number'   => 'required_if:applied,1|max:25',
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
            $this->selected = $this->vaccinations->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->selected = [];
        }
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
		$this->modalTitle = 'Vaccinations';
		$this->pageTitle = 'Vaccinations';
		$this->modalApplyTitle = 'Vaccination';
		$this->addButton = 'Register vaccination';
	}

	public function getVaccinationsProperty()
	{
		if ($this->readyToLoad) {
			return $this->pet->vaccinations()
				->join('vaccines as v', 'v.id', 'vaccinations.vaccine_id')
				->select('vaccinations.id',
					'vaccinations.type',
					'vaccinations.batch_number',
					'vaccinations.done',
					'vaccinations.applied',
					'vaccinations.dose_number',
					'vaccinations.doses_required',
					'v.name as name',
					'v.description as description',
					'v.vaccination_schedule',
					'v.vaccination_doses',
					'v.revaccination_doses',
					'v.revaccination_schedule')
				->when(strlen($this->search) > 0, function ($query) {
                    $query->where('name', 'like', '%' . $this->search .'%');
                })
		 		->orderBy($this->sort, $this->direction)
		 		->paginate($this->paginate);
		} else {
			return [];
		}
	}

	public function getVaccinesProperty()
	{
		return Species::findOrFail($this->pet->species->id)->vaccines->sortByDesc('status');
	}

	public function render()
	{
		$this->authorize('vaccinations_index');

		// FOR FORM
		if ($this->vaccine_id) {
			if ($this->type != 'choose') {
				if ($this->type == 'Vaccination') {
					$this->suggested_doses = Vaccine::find($this->vaccine_id)->vaccination_doses;
				} elseif ($this->type == 'Revaccination') {
					$this->suggested_doses = Vaccine::find($this->vaccine_id)->revaccination_doses;
				}
			}
		}

		return view('livewire.inline.vaccinations', [
			'vaccinations' => $this->vaccinations,
			'vaccines' => $this->vaccines
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
		$this->authorize('vaccinations_store');

		$validatedData = $this->validate();

		$this->pet->vaccinations()->create($validatedData);

		$this->dispatchBrowserEvent('stored', [
			'title' => 'Created',
			'subtitle' => 'Succesfully!',
			'class' => 'bg-primary',
			'icon' => 'fas fa-plus fa-lg',
			'image' => auth()->user()->profile_photo_url,
			'body' => '¡Vaccination has been stored correctly!.'
		]);

		$this->resetUI();
		$this->emit('hide-modal', 'hide-modal');
	}


	public function editApply(Vaccination $vaccination)
	{
		$this->authorize('vaccinations_update');

		$this->selected_id = $vaccination->id;
		$this->vaccine_id = $vaccination->vaccine_id;
		$this->type = $vaccination->type;
		$this->batch_number = $vaccination->batch_number;
		$this->dose_number = $vaccination->dose_number;
		$this->doses_required = $vaccination->doses_required;
		$this->done = $vaccination->done->format('Y-m-d');
		$this->applied = $vaccination->applied;

		$this->emit('show-modal-apply', 'show-modal-apply');
	}

	public function apply()
	{
		$this->authorize('vaccinations_update');

		$this->validate([
			'batch_number' => 'required|regex:/([a-zA-Z0-9]{3})([-. ]?)([a-zA-Z0-9]{2})([-. ]?)([a-zA-Z0-9]{4})/'
        ]);

		$vaccination = Vaccination::findOrFail($this->selected_id);

		if ($vaccination->applied == 0) {
			$vaccination->batch_number = $this->batch_number;
			$vaccination->applied = 1;
			$vaccination->save();

			$this->dispatchBrowserEvent('applied', [
				'title' => 'Applied',
				'subtitle' => 'Succesfully!',
				'class' => 'bg-success',
				'icon' => 'fas fa-check-circle fa-lg',
				'image' => auth()->user()->profile_photo_url,
				'body' => 'Vaccination has been applied correctly.'
			]);

		} elseif ($vaccination->applied == 1) {
			$vaccination->batch_number = '';
			$vaccination->applied = 0;
			$vaccination->save();

			$this->dispatchBrowserEvent('undo-applied', [
				'title' => 'Undo Applied',
				'subtitle' => 'Succesfully!',
				'class' => 'bg-danger',
				'icon' => 'fas fa-check-circle fa-lg',
				'image' => auth()->user()->profile_photo_url,
				'body' => 'Undo Vaccination has been applied correctly.'
			]);
		}

		$this->emit('hide-modal-apply', 'hide-modal-apply');
		$this->resetUI();
	}

	public function edit(Vaccination $vaccination)
	{
		$this->selected_id = $vaccination->id;
		$this->vaccine_id = $vaccination->vaccine_id;
		$this->type = $vaccination->type;
		$this->batch_number = $vaccination->batch_number;
		$this->dose_number = $vaccination->dose_number;
		$this->doses_required = $vaccination->doses_required;
		$this->done = $vaccination->done->format('Y-m-d');
		$this->applied = $vaccination->applied;

		$this->emit('show-modal', 'show-modal');
	}

	public function update()
	{
		$this->authorize('vaccinations_update');

		$validatedData = $this->validate();
		$vaccination = Vaccination::findOrFail($this->selected_id);
		$vaccination->update($validatedData);

		$this->emit('hide-modal', 'hide-modal');

		$this->resetUI();

		$this->dispatchBrowserEvent('updated', [
			'title' => 'Updated',
			'subtitle' => 'Succesfully!',
			'class' => 'bg-success',
			'icon' => 'fas fa-check-circle fa-lg',
			'image' => auth()->user()->profile_photo_url,
			'body' => 'Vaccination has been updated correctly.'
		]);
	}

	public function destroy($id)
	{
		$this->authorize('vaccinations_destroy');

        Vaccination::find($id)->delete();

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
        $this->authorize('vaccinations_destroy');

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

            $deletedtems = Vaccination::whereIn('id', $this->selected)
                ->select('id')
                ->pluck('id')
                ->toArray();

            Vaccination::destroy($this->selected);

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

        //Restaura los ids contenidos en la última posición del array
        Vaccination::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = Vaccination::whereIn('id', $this->deleted[$last])
            ->select('id')
            ->pluck('id')
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

    public function startVaccinationSchedule($species_id)
    {
    	// 6-8: parvo, distemper, optional bordetella | Nobivac® DP PLUS

    	// 10-12: distemper, infectios hepatitis, canine parvovirus, leptospirosis (recomended) | Nobivac® DHPPi + Nobivac® L4

		// 16-18: distemper, infectios hepatitis, canine parvovirus, leptospirosis (recomended), Contagious Canine Cough (optional), rabies (required) | DAPPv+L4 + Nobivac® L4 + NOBIVAC® RABIA.

    	//12-16 months: Nobivac® DHPPi

    	// every 1-3 years: Nobivac® DHPPi + NOBIVAC® RABIA

    }

	public function resetUI()
	{
		// CRUD attributes
		$this->selected_id = '';
		$this->vaccine_id = 'choose';
		$this->type = 'choose';
		$this->batch_number = '';
		$this->dose_number = '';
		$this->doses_required = '';
		$this->done = '';
		$this->applied = null;

		$this->selected = [];
        $this->select_page = false;
        $this->search = '';

		$this->resetValidation();
        $this->resetPage();
		// $this->next = "{$this->cuantity} {$this->period}"
	}

}
