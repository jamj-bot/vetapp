<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Pet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ConsultationController extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Datatable attributes
    public $paginate = '50', $sort = 'updated_at', $direction = 'desc', $readyToLoad = false, $search = '';

    // General attributes
    public $pageTitle, $modalTitle;

    public $pet;

    // CRUD attributes
    public $selected_id,
        $age,
        $weight,
        $temperature,
        $capillary_refill_time = 'choose',
        $heart_rate,
        $pulse = 'choose',
        $respiratory_rate,
        $reproductive_status = 'choose',
        $consciousness = 'choose',
        $hydration = 'choose',
        $pain = 'choose',
        $body_condition = 'choose',
        $problem_statement,
        $diagnosis,
        $prognosis = 'Pending',
        $treatment_plan,
        $consult_status = 'choose';

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
        'sort'      => ['except' => 'updated_at'],
        'direction' => ['except' => 'desc']
    ];

     /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'age'                   => 'required|string|min:3|max:255',
            'weight'                => 'required|numeric|numeric|between:0,9999.999|regex:/^\d+(\.\d{1,3})?$/',
            'temperature'           => 'required|numeric|between:0,99.99|regex:/^\d+(\.\d{1,2})?$/',
            'capillary_refill_time' => 'required|in:"Less than 1 second","1-2 seconds","Longer than 2 seconds"',
            'heart_rate'            => 'required|integer|between:0,2000',
            'pulse'                 => 'required|in:"Strong and synchronous with each heart beat","Irregular","Bounding","Weak or absent"',
            'respiratory_rate'      => 'required|integer|between:0,200',
            'reproductive_status'   => 'required|in:"Pregnant","Lactating","Neither"',
            'consciousness'         => 'required|in:"Alert and responsive","Depressed or obtunded","Stupor","Comatose"',
            'hydration'             => 'required|in:"Normal","0-5%","6-7%","8-9%","+10%"',
            'pain'                  => 'required|in:"None","Vocalization","Changes in behavior","Physical changes"',
            'body_condition'        => 'required|in:"Too thin","Ideal","Too heavy"',
            'problem_statement'     => 'required|string|max:65000',
            'diagnosis'             => 'required|string|min:3|max:500',
            'prognosis'             => 'required|in:"Pending","Good","Fair","Guarded","Grave","Poor"',
            'treatment_plan'        => 'nullable|string|min:3|max:2000',
            'consult_status'        => 'required|in:"Lab pending tests", "Radiology pending tests", "Closed"',
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

    public function mount($pet)
    {
        $this->pageTitle = 'Consultations';
        $this->modalTitle = "Consultation";

        $this->pet = Pet::find($pet);
    }


    public function render()
    {
        // $pet = Pet::findOrFail($this->pet);

        if ($this->readyToLoad) {
            if (strlen($this->search) > 0) {
                $consultations = $this->pet->consultations()
                    ->select(['id', 'user_id', 'consult_status', 'diagnosis', 'prognosis', 'updated_at']) // get colums from consultations
                    ->with(['user:id,name']) // get columns from users table
                    ->where('diagnosis', 'like', '%'. $this->search .'%')
                    ->orWhere('problem_statement', 'like', '%'. $this->search .'%')
                    ->orderBy($this->sort, $this->direction)
                    ->simplePaginate($this->paginate);

            } else {
                $consultations = $this->pet->consultations()
                    ->select(['id', 'user_id', 'consult_status', 'diagnosis', 'prognosis', 'updated_at']) // get colums from consultations
                    ->with(['user:id,name']) // get columns from users table
                    ->orderBy($this->sort, $this->direction)
                    ->simplePaginate($this->paginate);
            }

        } else {
            $consultations = [];
        }

        return view('livewire.consultation.component', compact('consultations'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    /**
     *  El parametro que se recibe es el valor de campo
     *  oculto id ="textareaProblemStatement"
     *
     * */
    public function store($problem_statement)
    {
        $this->problem_statement = $problem_statement; // <- se asigna el parámetro a la propiedad $problem_statement

        // $pet = Pet::findOrFail($this->pet);
        $user = Auth::user();

        $validatedData = $this->validate();

        // instantiate a new consultation instance
        $consultation = new Consultation($validatedData);

        $consultation->user()->associate($user);
        $consultation->pet()->associate($this->pet);
        $consultation->save();

        // $pet->consultations()->create($validatedData);

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation stored'
        ]);

        $this->emit('hide-modal', 'hide-modal');
        $this->resetUI();
    }

    public function edit(Consultation $consultation)
    {
        $this->selected_id = $consultation->id;
        $this->age = $consultation->age;
        $this->weight = $consultation->weight;
        $this->temperature = $consultation->temperature;
        $this->capillary_refill_time = $consultation->capillary_refill_time;
        $this->heart_rate = $consultation->heart_rate;
        $this->pulse = $consultation->pulse;
        $this->respiratory_rate = $consultation->respiratory_rate;
        $this->reproductive_status = $consultation->reproductive_status;
        $this->consciousness = $consultation->consciousness;
        $this->hydration = $consultation->hydration;
        $this->pain = $consultation->pain;
        $this->body_condition = $consultation->body_condition;
        $this->problem_statement = $consultation->problem_statement;
        $this->diagnosis = $consultation->diagnosis;
        $this->prognosis = $consultation->prognosis;
        $this->treatment_plan = $consultation->treatment_plan;
        $this->consult_status = $consultation->consult_status;

        $this->emit('show-modal', 'show-modal');
    }

    /*
     * El parámetro que se recibe el el valor del campo oculto id ="textareaProblemStatement"
     *
     */
    public function update($problem_statement)
    {
        $this->problem_statement = $problem_statement; // <- se asigna el parámetro a la propiedad $problem_statement


        $validatedData = $this->validate();
        $consultation = consultation::findOrFail($this->selected_id);
        $consultation->update($validatedData);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation updated.'
        ]);
    }


    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation deleted.'
        ]);
    }

    public function resetUI()
    {
        $this->selected_id = '';
        $this->age = '';
        $this->weight = null;
        $this->temperature = null;
        $this->capillary_refill_time = 'choose';
        $this->heart_rate = null;
        $this->pulse = 'choose';
        $this->respiratory_rate = null;
        $this->reproductive_status = 'choose';
        $this->consciousness = 'choose';
        $this->hydration = 'choose';
        $this->pain = 'choose';
        $this->body_condition = 'choose';
        $this->problem_statement = '';
        $this->diagnosis = '';
        $this->prognosis = 'Pending';
        $this->treatment_plan = '';
        $this->consult_status = 'choose';

        $this->emit('reset-ckeditor', 'reset-ckeditor');
    }
}
