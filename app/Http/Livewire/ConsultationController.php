<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Pet;
use Carbon\Carbon;
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
    public $paginate = '50',
        $sort = 'updated_at',
        $direction = 'desc',
        $readyToLoad = false,
        $search = '',
        $filter = 'All',
        $checkedConsultations = [],
        $checkAllConsultations = false;

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
        $prognosis = 'choose',
        $treatment_plan,
        $consult_status = 'choose';

    // Listeners
    protected $listeners = [
        'destroy' => 'destroy', // softdelete a la consulta específica
        'forceDelete' => 'forceDelete', // forceDelete a la consulta específica
        'deleteChecked' => 'deleteChecked',
        'destroyChecked' => 'destroyChecked',
        'restoreChecked' => 'restoreChecked',
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
            'age'                   => 'nullable|string|min:3|max:255',
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
            'diagnosis'             => 'nullable|string|min:3|max:500',
            'prognosis'             => 'required|in:"Pending","Good","Fair","Guarded","Grave","Poor"',
            'treatment_plan'        => 'nullable|string|min:3|max:2000',
            'consult_status'        => 'required|in:"Lab tests pending", "Radiology tests pending", "Closed"',
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

        // Al escribir en el buscador, se limpian los items seleccionados
        $this->checkAllConsultations = false;
        $this->checkedConsultations = [];
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

        //$this->age = Carbon::createFromDate($this->pet->dob)->diff(Carbon::now())->format('%y years, %m months and %d days');

        $this->problem_statement = '<h4>Anamnesis</h4><h4>Análisis por sistema</h4><h5>Piel y anexos</h5><h5>Sistema linfático</h5><h5>Sistema musculo esquelético</h5><h5>Sistema nervioso</h5><h5>Sistema genital</h5><h5>Sistema urinario</h5><h5>Sistema respiratorio</h5><h5>Sistema cardiovascular</h5><h5>Sistema digestivo</h5><h5>Visión y oido</h5><h4>Lista de problemas</h4><h4>Lista maestra</h4><h4>Plan diagnóstico&nbsp;</h4><p>&nbsp;</p>';
    }


    public function render()
    {
        $this->authorize('consultations_index');

        if ($this->readyToLoad) {
            if ($this->filter == 'All') {
                if (strlen($this->search) > 0) {
                    $consultations = $this->pet->consultations()
                        ->select(['id', 'user_id', 'consult_status', 'diagnosis', 'prognosis', 'updated_at'])
                        ->with(['user:id,name']) // eager loading
                        ->where(function ($query) {
                            $query->where('diagnosis', 'like', '%'. $this->search .'%')
                                ->orWhere('prognosis', 'like', '%'. $this->search .'%');
                        })->orderBy($this->sort, $this->direction)
                            ->simplePaginate($this->paginate);
                } else {
                    $consultations = $this->pet->consultations()
                        ->select(['id', 'user_id', 'consult_status', 'diagnosis', 'prognosis', 'updated_at'])
                        ->with(['user:id,name']) // eager loading
                        ->orderBy($this->sort, $this->direction)
                        ->simplePaginate($this->paginate);
                }
            }

            if ($this->filter == 'Trash') {
                if (strlen($this->search) > 0) {
                    $consultations = $this->pet->consultations()
                        ->onlyTrashed()
                        ->select(['id', 'user_id', 'consult_status', 'diagnosis', 'prognosis', 'updated_at'])
                        ->with(['user:id,name']) // eager loading
                        ->where(function ($query) {
                            $query->where('diagnosis', 'like', '%'. $this->search .'%')
                                ->orWhere('prognosis', 'like', '%'. $this->search .'%');
                        })->orderBy($this->sort, $this->direction)
                            ->simplePaginate($this->paginate);
                } else {
                    $consultations = $this->pet->consultations()
                        ->onlyTrashed()
                        ->select(['id', 'user_id', 'consult_status', 'diagnosis', 'prognosis', 'updated_at'])
                        ->with(['user:id,name']) // get columns from users table
                        ->orderBy($this->sort, $this->direction)
                        ->simplePaginate($this->paginate);
                }
            }

            // Asigno un color a la cansulta
            foreach ($consultations as $consultation) {
                switch ($consultation->prognosis) {
                    case 'Good':
                        $consultation->color = 'text-success';
                        break;
                    case 'Fair':
                        $consultation->color = 'text-olive';
                        break;

                    case 'Guarded':
                        $consultation->color = 'text-warning';
                        break;

                    case 'Grave':
                        $consultation->color = 'text-orange';
                        break;

                    case 'Poor':
                        $consultation->color = 'text-danger';
                        break;

                    default:
                        $consultation->color = 'text-muted';
                        break;
                }
            }
        } else {
            $consultations = [];
        }

        $consultations_quantity = $this->pet->consultations()->count();
        $deleted_consultations_quantity = $this->pet->consultations()->onlyTrashed()->count();


        return view('livewire.consultation.component', compact('consultations', 'consultations_quantity', 'deleted_consultations_quantity'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function loadDobField()
    {
        // Se asigna $this-pet-dob (d-m-Y) en la propiedad $age (0 years, 0 months, 0 days)
        $this->age = Carbon::createFromDate($this->pet->dob)->diff(Carbon::now())->format('%y years, %m months and %d days');
        // $this->problem_statement = '';

        $this->emit('show-modal', 'show-modal');
    }

    /**
     *  El parametro que se recibe es el valor de campo
     *  oculto id ="textareaProblemStatement"
     *
     * */
    public function store($problem_statement)
    {
        $this->authorize('consultations_store');

        // Se asigna el parámetro a la propiedad $problem_statement
        $this->problem_statement = $problem_statement;

        $user = Auth::user();

        $validatedData = $this->validate();

        // instantiate a new consultation instance
        $consultation = new Consultation($validatedData);

        $consultation->user()->associate($user);
        $consultation->pet()->associate($this->pet);
        $consultation->save();

        $this->checkedConsultations = [];

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


    public function destroy(Consultation $consultation)
    {
        $this->authorize('consultations_destroy');

        $consultation->delete();

        // $this->dispatchBrowserEvent('swal:deleteConsultations', [
        //     'title' => 'Are you sure?',
        //     'html'  => 'You want to delete this consultations',
        //     'checkIDs' => $this->checkedConsultations,
        // ]);

        $this->checkedConsultations = [];

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation deleted.'
        ]);
    }

    public function forceDelete($id)
    {
        $this->authorize('consultations_delete');

        $consultation = Consultation::withTrashed()->findOrFail($id);

        $consultation->forceDelete();

        // $this->dispatchBrowserEvent('swal:deleteConsultations', [
        //     'title' => 'Are you sure?',
        //     'html'  => 'You want to delete this consultations',
        //     'checkIDs' => $this->checkedConsultations,
        // ]);

        $this->checkedConsultations = [];

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation deleted.'
        ]);
    }

    public function restore($id)
    {
        $this->authorize('consultations_restore');

        $consultation = Consultation::withTrashed()->findOrFail($id);

        $consultation->restore();

        $this->checkedConsultations = [];

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-info',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation restored.'
        ]);
    }

    public function updateCheckAllConsultations()
    {
        if ($this->filter == 'All') {
            if ($this->checkAllConsultations == false) {
                $this->checkedConsultations =  $this->pet->consultations()
                    ->where(function($query) {
                        $query->where('diagnosis', 'like', '%'. $this->search .'%')
                            ->orWhere('problem_statement', 'like', '%'. $this->search .'%');
                    })
                    ->orderBy($this->sort, $this->direction)
                    ->simplePaginate($this->paginate)
                    ->pluck('id');
                $this->checkAllConsultations = true;
            } else {
                $this->checkedConsultations = [];
                $this->checkAllConsultations = false;
            }
        } elseif ($this->filter == 'Trash') {
            if ($this->checkAllConsultations == false) {
                $this->checkedConsultations =  $this->pet->consultations()
                    ->onlyTrashed()
                    ->where(function($query) {
                        $query->where('diagnosis', 'like', '%'. $this->search .'%')
                            ->orWhere('problem_statement', 'like', '%'. $this->search .'%');
                    })
                    ->orderBy($this->sort, $this->direction)
                    ->simplePaginate($this->paginate)
                    ->pluck('id');
                $this->checkAllConsultations = true;
            } else {
                $this->checkedConsultations = [];
                $this->checkAllConsultations = false;
            }
        }
    }

    public function deleteChecked()
    {
        $ids = $this->checkedConsultations;
        Consultation::whereKey($ids)->delete();
        $this->checkedConsultations = [];
        $this->checkAllConsultations = false;

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultations deleted.'
        ]);
    }

    public function destroyChecked()
    {
        $ids = $this->checkedConsultations;
        Consultation::whereKey($ids)->forceDelete();
        $this->checkedConsultations = [];
        $this->checkAllConsultations = false;

        $this->dispatchBrowserEvent('destroyed', [
            'title' => 'Destroyed',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultations destroyed.'
        ]);
    }

    public function restoreChecked()
    {
        $ids = $this->checkedConsultations;

        Consultation::whereKey($ids)->restore();
        $this->checkedConsultations = [];
        $this->checkAllConsultations = false;

        $this->dispatchBrowserEvent('restored', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultations restored.'
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
        $this->prognosis = 'choose';
        $this->treatment_plan = '';
        $this->consult_status = 'choose';

        $this->resetValidation();
        $this->emit('reset-ckeditor', 'reset-ckeditor');
    }
}
