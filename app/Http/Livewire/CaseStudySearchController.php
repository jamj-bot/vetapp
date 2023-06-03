<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Species;
use App\Models\Veterinarian;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class CaseStudySearchController extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search fields
    public $species_ids = [],
        $min_age = 0,
        $max_age = 100,
        $min_date,
        $max_date,
        $veterinarians_ids = [],
        $diseases_ids = [],
        $treatment_terms = '',
        $symptoms_terms = '',
        $consultations = [];

    // General attributes
    public $pageTitle, $modalTitle;

    protected $listeners = [
        'selectedOptionsChanged',
        'selectedVeterinariansChanged',
        'selectedDiseasesChanged'
    ];

    /**
     *  Function that returns the validation rules
     *
    **/
    public function rules()
    {
        return [
            // 'species_ids'         => 'nullable|array|min:1',
            'species_ids.*'       => 'nullable|exists:species,id',

            'min_date'            => 'nullable|date|before:max_date',
            'max_date'            => 'nullable|date|after:min_date',

            'symptoms_terms'      => 'nullable|string|max:255',

            // 'veterinarians_ids'   => 'nullable|array|min:1',
            'veterinarians_ids.*' => 'nullable|exists:users,id',

            // 'diseases_ids'        => 'nullable|array|min:1',
            'diseases_ids.*'      => 'nullable|exists:diseases,id',

            'treatment_terms'     => 'nullable|string|max:255',
        ];
    }

    public function selectedOptionsChanged($selectedOptions)
    {
        $this->species_ids = $selectedOptions;
    }

    public function selectedVeterinariansChanged($selectedOptions)
    {
        $this->veterinarians_ids = $selectedOptions;
    }

    public function selectedDiseasesChanged($selectedOptions)
    {
        $this->diseases_ids = $selectedOptions;
    }


    public function mount()
    {
        $this->pageTitle = 'Case Study Search';

        $this->veterinarians_ids = Veterinarian::with(['user' => function ($query) {
            $query->select('id');
        }])->get()->pluck('user.id')->toArray();

        $this->min_date = $this->date = now()->subYear()->toDateString();
        $this->max_date = $this->date = now()->addDay()->toDateString();
    }

    public function getSpeciesProperty()
    {
        return Species::all();
    }

    public function getVeterinariansProperty()
    {
        return Veterinarian::with(['user' => function ($query) {
            $query->select('id', 'name', 'email', 'profile_photo_path');
        }])->get();
    }

    public function getDiseasesProperty()
    {
        return Consultation::whereHas('diseases')
            ->with(['diseases' => function ($query) {
                $query->distinct();
            }])
            ->get()
            ->pluck('diseases')
            ->flatten()
            ->unique('id');
    }

    public function render()
    {
        return view('livewire.case-study-search.component', [
                'species' => $this->species,
                'veterinarians' => $this->veterinarians,
                'diseases' => $this->diseases,
                'consultations' => $this->consultations
            ])
            ->extends('admin.layout.app')
            ->section('content');;
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $treatment_keywords = preg_split('/[;]+/', $this->treatment_terms);
        $treatment_keywords = array_filter($treatment_keywords);

        $symptoms_keywords = preg_split('/[;]+/', $this->symptoms_terms);
        $symptoms_keywords = array_filter($symptoms_keywords);



        $this->consultations =
        // Solo cosnultas relacionadas con las especies seleccionadas.
        Consultation::whereHas('pet.species', function ($query) {
            $query->whereIn('species_id', $this->species_ids);
        })

        // Solo consultas que tienen alguno de los problemas ingresados.
        ->where(function ($query) use ($symptoms_keywords) {
            foreach ($symptoms_keywords as $keyword) {
                $query->orWhere(function ($query) use ($keyword) {
                    $query->where('problem_statement', 'like', '%'. $keyword .'%');
                });
            }
        })

        // Solo consultas que tienen incluyen alguno de los planes de tratamiento ingresados.
        ->where(function ($query) use ($treatment_keywords) {
            foreach ($treatment_keywords as $keyword) {
                $query->orWhere(function ($query) use ($keyword) {
                    $query->where('treatment_plan', 'like', '%'. $keyword .'%');
                });
            }
        })

        // Cuando hay enfermedades seleccionadas, solo devuelve las consultas relacionadas con todas las enfermedades
        ->when(count($this->diseases_ids) > 0, function ($query) {
            foreach ($this->diseases_ids as $disease_id) {
                $query->whereHas('diseases', function ($query) use ($disease_id) {
                    $query->where('disease_id', $disease_id);
                });
            }
        }, function ($query) {
            return $query; // If there are no diseases selected, return all consultations
        })

        // Cuando hay enfermedades seleccionadas, devuelve las consultas que tienen relacionada alguna de las enfermedades seleccionadas.
        // ->when(count($this->diseases_ids) > 0, function ($query) {
        //     $query->whereHas('diseases', function ($query) {
        //         $query->whereIn('disease_id', $this->diseases_ids);
        //     });
        // })

        ->whereIn('user_id', $this->veterinarians_ids)
        ->whereBetween('created_at', [$this->min_date, $this->max_date])
        ->get();
    }
}

