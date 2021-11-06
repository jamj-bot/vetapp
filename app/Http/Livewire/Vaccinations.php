<?php

namespace App\Http\Livewire;

use App\Models\Vaccine;
use App\Models\Vaccination;
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
	public $paginate = '50', $sort = 'vaccine_id', $direction = 'asc', $readyToLoad = false, $search = '';

	// General attrbibutes to component
	public $modalTitle;

	// CRUD attributes
	public $selected_id, $vaccine_id, $type = 'choose', $batch_number, $dose_number, $doses_required, $done, $applied = 0;

	// Listeners
	protected $listeners = [
		'destroy'
	];

	/**
	 *  Function that returns the validation rules [-. ]* \(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/      /[a-zA-Z0-9\s]+/
	 *
	**/
	protected function rules()
	{
		return [
			'vaccine_id' => 'required|not_in:choose',
			'type' => 'required|not_in:choose',
			'batch_number' => 'nullable|regex:/([a-zA-Z0-9]{3})([-. ]?)([a-zA-Z0-9]{2})([-. ]?)([a-zA-Z0-9]{4})/',
			'dose_number' => 'required|integer|between:1,5',
			'doses_required' => 'required|integer|between:1,5',
			'done' => 'required|date',
			'applied' => 'required|boolean',
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
		$this->modalTitle = 'Vaccinations';
	}

	public function render()
	{
		$this->authorize('vaccinations_index');

		if ($this->readyToLoad) {
        // $this->details = SaleDetail::join('products as p', 'p.id', 'sale_details.product_id')
        //     ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'p.name as product')
        //     ->where('sale_details.sale_id', $saleId)
        //     ->get();

			if (strlen($this->search) > 0) {
				$vaccinations = $this->pet->vaccinations()
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
						'v.primary_vaccination',
						'v.primary_doses',
						'v.revaccination_doses',
						'v.revaccination_interval')
					->where('name', 'like', '%' . $this->search .'%')
			 		->orderBy($this->sort, $this->direction)
			 		->simplePaginate($this->paginate);
			} else {
				$vaccinations = $this->pet->vaccinations()
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
						'v.primary_vaccination',
						'v.primary_doses',
						'v.revaccination_doses',
						'v.revaccination_interval')
			 		->orderBy($this->sort, $this->direction)
			 		->simplePaginate($this->paginate);
			}
		} else {
			$vaccinations = [];
		}

		$vaccines = Vaccine::orderBy('description', 'asc')->get();


		// FOR FORM
		if ($this->vaccine_id) {
			if ($this->type != 'choose') {
				if ($this->type == 'Vaccination') {
					$this->doses_required = Vaccine::find($this->vaccine_id)->primary_doses;
				} elseif ($this->type == 'Revaccination') {
					$this->doses_required = Vaccine::find($this->vaccine_id)->revaccination_doses;
				}
			}
		}

		return view('livewire.vaccinations', compact('vaccinations', 'vaccines'));
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


	public function apply(Vaccination $vaccination)
	{
		$this->authorize('vaccinations_update');

		if ($vaccination->applied == 0) {

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


		$this->resetUI();

		// $this->emit('show-modal', 'show-modal');
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
		$vaccination = Vaccination::find($this->selected_id);
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

	public function destroy(Vaccination $vaccination)
	{
		$this->authorize('vaccinations_destroy');
		$vaccination->delete();

		$this->dispatchBrowserEvent('deleted', [
			'title' => 'Deleted',
			'subtitle' => 'Succesfully!',
			'class' => 'bg-danger',
			'icon' => 'fas fa-check-circle fa-lg',
			'image' => auth()->user()->profile_photo_url,
			'body' => 'Vaccination has been deleted correctly.'
		]);
	}

	public function resetUI()
	{
		$this->selected_id = '';
		$this->vaccine_id = 'choose';
		$this->type = 'choose';
		$this->batch_number = '';
		$this->dose_number = '';
		$this->doses_required = '';
		$this->done = '';
		$this->applied = 0;
		$this->resetValidation();
	}

}
