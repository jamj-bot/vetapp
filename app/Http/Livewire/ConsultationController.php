<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Disease;
use App\Models\Pet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        $selected = [],
        $select_page;

    // General attributes
    public $pageTitle, $modalTitle;

    public $pet;

    // CRUD attributes
    public $selected_id,
        $age,
        $weight,
        $temperature,
        $oxygen_saturation_level,
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
        $types_of_diagnosis = [],
        $prognosis = 'choose',
        $color = '',
        $treatment_plan,
        $consult_status = 'choose',
        $disease = '';

    // Stteper

    // Listeners
    protected $listeners = [
        'softDelete' => 'softDelete', // softdelete a la consulta específica
        'destroy' => 'destroy', // forceDelete a la consulta específica
        'destroyMultiple' => 'destroyMultiple',
        'restoreMultiple' => 'restoreMultiple',
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
            'age'                     => 'nullable|string|min:3|max:255',
            'weight'                  => 'required|numeric|numeric|between:0,9999.999|regex:/^\d+(\.\d{1,3})?$/',
            'temperature'             => 'required|numeric|between:0,99.99|regex:/^\d+(\.\d{1,2})?$/',
            'oxygen_saturation_level' => 'nullable|integer|between:0,100',
            'capillary_refill_time'   => 'required|in:"Less than 1 second","1-2 seconds","Longer than 2 seconds"',
            'heart_rate'              => 'required|integer|between:0,2000',
            'pulse'                   => 'required|in:"Strong and synchronous with each heart beat","Irregular","Bounding","Weak or absent"',
            'respiratory_rate'        => 'required|integer|between:0,200',
            'reproductive_status'     => 'required|in:"Pregnant","Lactating","Neither"',
            'consciousness'           => 'required|in:"Alert and responsive","Depressed or obtunded","Stupor","Comatose"',
            'hydration'               => 'required|in:"Normal","0-5%","6-7%","8-9%","+10%"',
            'pain'                    => 'required|in:"None","Vocalization","Changes in behavior","Physical changes"',
            'body_condition'          => 'required|in:"Very thin","Thin","Normal","Fat","Very fat"',
            'problem_statement'       => 'required|string|max:65000',
            'disease'                 => 'required|max:255',
            'types_of_diagnosis'      => 'required|max:255',
            'prognosis'               => 'required|in:"Pending","Good","Fair","Guarded","Grave","Poor"',
            'treatment_plan'          => 'nullable|string|min:3|max:2000',
            'consult_status'          => 'required|in:"In process", "Closed"',
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
            $this->selected = $this->consultations->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->selected = [];
        }
    }

    /**
     *  Check or all function
     *
    **/
    public function updatedFilter($value)
    {
        $this->select_page = false;
        $this->selected = [];
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

    public function mount($pet)
    {
        $this->pageTitle = 'Consultations';
        $this->modalTitle = "Consultation";
        $this->pet = Pet::find($pet);
        $this->problem_statement = '<h4>Anamnesis</h4><h4>Análisis por sistema</h4>
            <h5>Piel y anexos</h5>
            <h5>Sistema linfático</h5>
            <h5>Sistema musculo esquelético</h5>
            <h5>Sistema nervioso</h5>
            <h5>Sistema genital</h5>
            <h5>Sistema urinario</h5>
            <h5>Sistema respiratorio</h5>
            <h5>Sistema cardiovascular</h5>
            <h5>Sistema digestivo</h5>
            <h5>Visión y oido</h5>
            <h4>Lista de problemas</h4>
            <h4>Lista maestra</h4>
            <h4>Plan diagnóstico&nbsp;</h4>
            <p>&nbsp;</p>';
    }


    public function getConsultationsProperty()
    {

        if ($this->readyToLoad) {
            if ($this->filter == 'All') {
                if (strlen($this->search) > 0) {
                    return $this->pet->consultations()
                        ->select(['id', 'user_id', 'consult_status', 'prognosis', 'color', 'updated_at'])
                        ->with(['user:id,name', 'diseases:name']) // eager loading
                        ->where(function ($query) {
                            $query->where('prognosis', 'like', '%'. $this->search .'%');
                        })->orWhereHas('diseases', function (Builder $query) {
                            $query->where('name', 'like', '%'. $this->search .'%');
                        })->orWhereHas('user', function (Builder $query) {
                            $query->where('name', 'like', '%'. $this->search .'%');
                        })->orderBy($this->sort, $this->direction)
                            ->simplePaginate($this->paginate);
                } else {
                    return $this->pet->consultations()
                        ->select(['id', 'user_id', 'consult_status', 'prognosis', 'color', 'updated_at'])
                        ->with(['user:id,name', 'diseases:name']) // eager loading
                        ->orderBy($this->sort, $this->direction)
                        ->simplePaginate($this->paginate);
                }
            }

            if ($this->filter == 'Trash') {
                if (strlen($this->search) > 0) {
                    return $this->pet->consultations()
                        ->onlyTrashed()
                        ->select(['id', 'user_id', 'consult_status', 'prognosis', 'color', 'updated_at'])
                        ->with(['user:id,name', 'diseases:name']) // eager loading
                        ->where(function ($query) {
                            //$query->where('diagnosis', 'like', '%'. $this->search .'%')
                            $query->where('prognosis', 'like', '%'. $this->search .'%');
                        })->orWhereHas('diseases', function (Builder $query) {
                            $query->where('name', 'like', '%'. $this->search .'%');
                        })->orWhereHas('user', function (Builder $query) {
                            $query->where('name', 'like', '%'. $this->search .'%');
                        })->orderBy($this->sort, $this->direction)
                            ->simplePaginate($this->paginate);
                } else {
                    return $this->pet->consultations()
                        ->onlyTrashed()
                        ->select(['id', 'user_id', 'consult_status', 'prognosis', 'color', 'updated_at'])
                        ->with(['user:id,name', 'diseases:name']) // get columns from users table
                        ->orderBy($this->sort, $this->direction)
                        ->simplePaginate($this->paginate);
                }
            }
        } else {
            return [];
        }
    }

    public function render()
    {
        $this->authorize('consultations_index');

        $this->diseases = Disease::all();

        return view('livewire.consultation.component', [
                'consultations' => $this->consultations,
                'consultations_quantity' => $this->pet->consultations()->count(),
                'deleted_consultations_quantity' => $this->pet->consultations()->onlyTrashed()->count()])
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function loadDobField()
    {
        // Se asigna $this-pet-dob (d-m-Y) en la propiedad $age (0 years, 0 months, 0 days)
        $this->age = Carbon::createFromDate($this->pet->dob)->diff(Carbon::now())->format('%y years, %m months and %d days');

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

        $this->types_of_diagnosis = implode(", ", $this->types_of_diagnosis);

        // Asigno un color a la cansulta
        switch ($this->prognosis) {
            case 'Good':
                $this->color = 'text-success';
                break;

            case 'Fair':
                $this->color = 'text-olive';
                break;

            case 'Guarded':
                $this->color = 'text-warning';
                break;

            case 'Grave':
                $this->color = 'text-orange';
                break;

            case 'Poor':
                $this->color = 'text-danger';
                break;

            case 'Pending':
                $this->color = 'text-muted';
                break;
        }

        $validatedData = $this->validate();

        $consultation = new Consultation($validatedData); // new consultation instance
        $consultation->user()->associate(Auth::user());
        $consultation->pet()->associate($this->pet);
        $consultation->color = $this->color;
        $consultation->save();

        // String disease, se convierte en
        foreach(explode("; ", $this->disease) as $disease)
        {
            $diseases[] = Disease::firstOrCreate(['name' => Str::of($disease)->trim()])->id;
        }
        $consultation->diseases()->attach($diseases);

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


    public function delete(Consultation $consultation)
    {
        $this->authorize('consultations_destroy');

        $consultation->delete();

        $this->selected = [];
        $this->select_page = false;

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation moved to recycle bin.'
        ]);

        // $this->dispatchBrowserEvent('swal:deleteConsultations', [
        //     'title' => 'Are you sure?',
        //     'html'  => 'You want to delete this consultations',
        //     'checkIDs' => $this->checkedConsultations,
        // ]);
    }

    public function destroy($id)
    {
        $this->authorize('consultations_delete');

        $consultation = Consultation::withTrashed()->findOrFail($id);

        $consultation->forceDelete();

        $this->selected = [];
        $this->select_page = false;

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation deleted.'
        ]);

        // $this->dispatchBrowserEvent('swal:deleteConsultations', [
        //     'title' => 'Are you sure?',
        //     'html'  => 'You want to delete this consultations',
        //     'checkIDs' => $this->checkedConsultations,
        // ]);
    }

    public function destroyMultiple()
    {
        //Si no hay ningun item seleccionado
        if (!$this->selected) {
            $this->dispatchBrowserEvent('deleted-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-light',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'No consultations selected.'
            ]);
            return;
        }

        if ($this->selected) {
            Consultation::whereKey($this->selected)->forceDelete();

            $this->dispatchBrowserEvent('destroyed', [
                'title' => 'Destroyed',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-danger',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'Consultations destroyed.'
            ]);
        }

        $this->selected = [];
        $this->select_page = false;
    }

    public function deleteMultiple()
    {
        $this->authorize('consultations_destroy');

        //Si no hay ningun item seleccionado
        if (!$this->selected) {
            $this->dispatchBrowserEvent('deleted-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-light',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'No consultations selected.'
            ]);
            return;
        }

        if ($this->selected) {
            Consultation::destroy($this->selected);
            $this->dispatchBrowserEvent('deleted', [
                'title' => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-danger',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'Consultations moved to Recycle bin.'
            ]);
        }

        $this->selected = [];
        $this->select_page = false;
    }

    public function restore($id)
    {
        $this->authorize('consultations_restore');

        $consultation = Consultation::withTrashed()->findOrFail($id);

        $consultation->restore();

        $this->selected = [];
        $this->select_page = false;

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-info',
            'icon' => 'fas fa-info fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation restored.'
        ]);
    }

    public function restoreMultiple()
    {
        //Si no hay ningun item seleccionado
        if (!$this->selected) {
            $this->dispatchBrowserEvent('deleted-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-light',
                'icon' => 'fas fa-info fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'No consultations selected.'
            ]);
            return;
        }

        if ($this->selected) {
            Consultation::whereKey($this->selected)->restore();

            $this->dispatchBrowserEvent('restored', [
                'title' => 'Restored',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-info',
                'icon' => 'fas fa-info fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'Consultations restored.'
            ]);
        }

        $this->selected = [];
        $this->select_page = false;
    }


    public function resetUI()
    {
        $this->selected_id = null;
        $this->age = '';
        $this->weight = null;
        $this->temperature = null;
        $this->oxygen_saturation_level = null;
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
        $this->types_of_diagnosis = [];
        $this->prognosis = 'choose';
        $this->color = '';
        $this->treatment_plan = '';
        $this->consult_status = 'choose';
        $this->disease = '';

        $this->selected = [];
        $this->select_page = false;

        $this->resetValidation();
        $this->emit('reset-ckeditor', 'reset-ckeditor');
    }
}
