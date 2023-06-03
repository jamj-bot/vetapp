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

    // Parameter
    public $pet;

    // Datatable attributes
    public $paginate = '50',
        $sort = 'updated_at',
        $direction = 'desc',
        $readyToLoad = false,
        $search = '',
        $filter = 'All',
        $selected = [],
        $deleted = [],
        $select_page = false;

    // General attributes
    public $pageTitle, $modalTitle;

    // Stepper
    public $totalSteps = 5, $currentStep = 1;
    public $steps = [
        1 => [
            'heading'    => 'Vital statics',
        ],
        2 => [
            'heading'    => 'Ancillary info',
        ],
        3 => [
            'heading'    => 'Problem',
        ],
        4 => [
            'heading'    => 'Dx and Tx',
        ],
        5 => [
            'heading'    => 'Save'
        ]
    ];

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
     *  Real time validation
     *
    **/
    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
        if ($this->currentStep == 1) {
            $this->validateOnly($propertyName, [
                'age'                     => 'nullable|string|min:3|max:255',
                'weight'                  => 'required|numeric|numeric|between:0,9999.999|regex:/^\d+(\.\d{1,3})?$/',
                'temperature'             => 'required|numeric|between:0,99.99|regex:/^\d+(\.\d{1,2})?$/',
                'oxygen_saturation_level' => 'nullable|integer|between:0,100',
                'capillary_refill_time'   => 'required|in:"Less than 1 second","1-2 seconds","Longer than 2 seconds"',
                'heart_rate'              => 'required|integer|between:0,2000',
                'pulse'                   => 'required|in:"Strong and synchronous with each heart beat","Irregular","Bounding","Weak or absent"',
                'respiratory_rate'        => 'required|integer|between:0,200',
            ]);
        }

        if ($this->currentStep == 2) {
            $this->validateOnly($propertyName, [
                'reproductive_status'     => 'required|in:"Pregnant","Lactating","Neither"',
                'consciousness'           => 'required|in:"Alert and responsive","Depressed or obtunded","Stupor","Comatose"',
                'hydration'               => 'required|in:"Normal","0-5%","6-7%","8-9%","+10%"',
                'pain'                    => 'required|in:"None","Vocalization","Changes in behavior","Physical changes"',
                'body_condition'          => 'required|in:"Very thin","Thin","Normal","Fat","Very fat"',
            ]);
        }

        if ($this->currentStep == 3) {
            $this->validateOnly($propertyName, [
                'problem_statement'       => 'required|string|max:65000',
            ]);
        }

        if ($this->currentStep == 4) {
            $this->validateOnly($propertyName, [
                'disease'                 => 'required|max:255',
                'types_of_diagnosis'      => 'required|max:255',
                'prognosis'               => 'required|in:"Pending","Good","Fair","Guarded","Grave","Poor"',
                'treatment_plan'          => 'nullable|string|min:3|max:2000',
                'consult_status'          => 'required|in:"In process", "Closed"',
            ]);
        }
    }

    public function goToNextStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $this->totalSteps;
        }

        // Reinicia el ckeditor
        $this->emit('reinitializeCkEditor');
    }

    public function goToPreviousStep()
    {
        $this->resetErrorBag();
        $this->currentStep--;
        if ($this->currentStep < 1) {
            $this->currentStep = 1;
        }

        // Reinicia el ckeditor
        $this->emit('reinitializeCkEditor');
    }

    /**
     *  Reset $select_page and $selected properties when pagination is updated
     *
    **/
    public function updatedPaginate()
    {
        $this->select_page = false;
        $this->selected = [];
    }

    /**
     *  Resetea la paginación y se limpian los items seleccionados cuando se escribe en el campo search
     *
    **/
    public function updatingSearch()
    {
        $this->resetPage();

        // Al escribir en campo search, se limpian los items seleccionados
        $this->select_page = false;
        $this->selected = [];
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

    // /**
    //  *  uncheck Select All
    //  *
    // **/
    // public function updatedSelected()
    // {
    //     $this->select_page = false;
    // }


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
        $this->currentStep = 1;
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
            return $this->pet->consultations()
                ->select(['id', 'user_id', 'consult_status', 'prognosis', 'color', 'updated_at'])
                ->with(['user:id,name', 'diseases:name']) // eager loading
                ->when($this->filter == 'In process', function ($query) {
                    $query->where('consult_status', 'In process');
                })
                ->when($this->filter == 'Closed', function ($query) {
                    $query->where('consult_status', 'Closed');
                })
                ->when(strlen($this->search) > 0, function ($query) {
                    // $query->where('prognosis', 'like', '%'. $this->search .'%');
                    $query->whereHas('diseases', function ($query) {
                        $query->where('name', 'like', '%'. $this->search .'%');
                    })->whereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
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

    public function validateData()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'age'                     => 'nullable|string|min:3|max:255',
                'weight'                  => 'required|numeric|numeric|between:0,9999.999|regex:/^\d+(\.\d{1,3})?$/',
                'temperature'             => 'required|numeric|between:0,99.99|regex:/^\d+(\.\d{1,2})?$/',
                'oxygen_saturation_level' => 'nullable|integer|between:0,100',
                'capillary_refill_time'   => 'required|in:"Less than 1 second","1-2 seconds","Longer than 2 seconds"',
                'heart_rate'              => 'required|integer|between:0,2000',
                'pulse'                   => 'required|in:"Strong and synchronous with each heart beat","Irregular","Bounding","Weak or absent"',
                'respiratory_rate'        => 'required|integer|between:0,200',
            ]);
        }

        if ($this->currentStep == 2) {
            $this->validate([
                'reproductive_status'     => 'required|in:"Pregnant","Lactating","Neither"',
                'consciousness'           => 'required|in:"Alert and responsive","Depressed or obtunded","Stupor","Comatose"',
                'hydration'               => 'required|in:"Normal","0-5%","6-7%","8-9%","+10%"',
                'pain'                    => 'required|in:"None","Vocalization","Changes in behavior","Physical changes"',
                'body_condition'          => 'required|in:"Very thin","Thin","Normal","Fat","Very fat"',
            ]);
        }

        if ($this->currentStep == 3) {
            $this->validate([
                'problem_statement'       => 'required|string|max:65000',
            ]);
        }

        if ($this->currentStep == 4) {
            $this->validate([
                'disease'                 => 'required|max:255',
                'types_of_diagnosis'      => 'required|max:255',
                'prognosis'               => 'required|in:"Pending","Good","Fair","Guarded","Grave","Poor"',
                'treatment_plan'          => 'nullable|string|min:3|max:2000',
                'consult_status'          => 'required|in:"In process", "Closed"',
            ]);
        }
    }

    public function submit()
    {
        if ($this->selected_id) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function loadDobField()
    {
        // Se asigna $this-pet-dob (d-m-Y) en la propiedad $age (0 years, 0 months, 0 days)
        $this->age = Carbon::createFromDate($this->pet->dob)->diff(Carbon::now())->format('%y years, %m months and %d days');

        $this->emit('show-modal', 'show-modal');
    }

    public function store()
    {
        $this->authorize('consultations_store');

        // Se asigna el parámetro a la propiedad $problem_statement
        //$this->problem_statement = $problem_statement;

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

    public function edit(Consultation $consultation)
    {
        $this->selected_id = $consultation->id;
        $this->age = $consultation->age;
        $this->weight = $consultation->weight;
        $this->temperature = $consultation->temperature;
        $this->oxygen_saturation_level = $consultation->oxygen_saturation_level;
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
        $this->types_of_diagnosis = explode(", ", $consultation->types_of_diagnosis);
        $this->prognosis = $consultation->prognosis;
        $this->treatment_plan = $consultation->treatment_plan;
        $this->consult_status = $consultation->consult_status;
        $this->disease = Str::ucfirst($consultation->diseases->implode('name', '; '));

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('consultations_update');

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

        // $colors = [
        //     'Good' => 'text-success',
        //     'Fair' => 'text-olive',
        //     'Guarded' => 'text-warning',
        //     'Grave' => 'text-orange',
        //     'Poor' => 'text-danger',
        //     'Pending' => 'text-muted'
        // ];

        // $this->color = $colors[$this->prognosis] ?? null;

        $validatedData = $this->validate();
        $consultation = consultation::findOrFail($this->selected_id);
        $consultation->color = $this->color;
        $consultation->update($validatedData);

        // String disease, se convierte en
        foreach(explode("; ", $this->disease) as $disease)
        {
            $diseases[] = Disease::firstOrCreate(['name' => Str::of($disease)->trim()])->id;
        }
        $consultation->diseases()->sync($diseases);

        $this->emit('hide-modal', 'hide-modal');

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation updated.'
        ]);

        $this->resetUI();
    }

    public function destroy($id)
    {
        $this->authorize('consultations_destroy');

        Consultation::find($id)->delete();

        $this->pushDeleted($id);

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation moved to recycle bin.'
        ]);

        $this->resetUI();

        // $this->dispatchBrowserEvent('swal:deleteConsultations', [
        //     'title' => 'Are you sure?',
        //     'html'  => 'You want to delete this consultations',
        //     'checkIDs' => $this->checkedConsultations,
        // ]);
    }

    public function destroyMultiple()
    {
        $this->authorize('consultation_destroy');

        //Si no hay items seleccionados
        if (!$this->selected) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title'    => 'Not deleted',
                'subtitle' => 'Warning!',
                'class'    => 'bg-light',
                'icon'     => 'fas fa-exclamation-triangle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => '0 items selected'
            ]);
            return;
        }

        // Eliminando los items que sí se pueden borrar
        if ($this->selected) {
            // Agregando al array $deleted aquellos que items que sí se pueden borrar
            $this->pushDeleted();

            $deletedItems = Consultation::whereIn('id', $this->selected)
                ->select('hydration')
                ->pluck('hydration')
                ->toArray();

            Consultation::destroy($this->selected);

            $this->dispatchBrowserEvent('deleted', [
                'title'    => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class'    => 'bg-danger',
                'icon'     => 'fas fa-check-circle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => count($deletedItems). ' items moved to Recycle bin: ' . implode(", ", $deletedItems)
            ]);
        }

        $this->resetUI();
    }

    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);

        // Restaura los ids contenidos en la última posición del array
        Consultation::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = Consultation::whereIn('id', $this->deleted[$last])
            ->select('hydration')
            ->pluck('hydration')
            ->toArray();

        $this->dispatchBrowserEvent('restored', [
            'title'    => 'Restored',
            'subtitle' => 'Succesfully!',
            'class'    => 'bg-success',
            'icon'     => 'fas fa-check-circle fa-lg',
            'image'    => auth()->user()->profile_photo_url,
            'body'     => count($restoredItems). ' items restored: ' . implode(", ", $restoredItems)
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

        $this->currentStep = 1;

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        // $this->emit('reset-ckeditor', 'reset-ckeditor');
    }
}
