<?php

namespace App\Http\Livewire;

use App\Models\Pet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class PetController extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Datatable attributes
    public $paginate = '50', $sort = 'updated_at', $direction = 'desc', $readyToLoad = false, $search = '';

    // General attributes
    public $pageTitle, $modalTitle;


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
        $this->pageTitle = 'Pets';
        $this->modalTitle = 'Pet';
    }

    public function getPetsProperty()
    {
        if ($this->readyToLoad) {
            return Pet::join('species as s', 's.id', 'pets.species_id')
                ->join('users as u', 'u.id', 'pets.user_id')
                ->select('pets.id',
                    'pets.code',
                    'pets.name',
                    'pets.breed',
                    'pets.zootechnical_function',
                    'pets.status',
                    'pets.image',
                    'pets.updated_at',
                    'pets.user_id',
                    's.name as common_name',
                    's.scientific_name',
                    'u.name as user_name')
                ->when(strlen($this->search) > 0, function ($query) {
                    $query->where('pets.code' , 'like', '%' . $this->search . '%')
                        ->orWhere('pets.name' , 'like', '%' . $this->search . '%')
                        ->orWhere('pets.breed' , 'like', '%' . $this->search . '%')
                        ->orWhere('pets.zootechnical_function' , 'like', '%' . $this->search . '%')
                        ->orWhere('pets.status' , 'like', '%' . $this->search . '%')
                        ->orWhere('s.name' , 'like', '%' . $this->search . '%')
                        ->orWhere('u.name' , 'like', '%' . $this->search . '%')
                        ->orWhere('s.scientific_name' , 'like', '%' . $this->search . '%');
                 })
                ->orderBy($this->sort, $this->direction)
                ->orderBy('u.name', $this->direction)
                ->paginate($this->paginate);

        } else {
            return [];
        }
    }

    public function render()
    {
        $this->authorize('pets_index');

        // if ($this->readyToLoad) {
        //     if (strlen($this->search) > 0) {
        //         $pets = Pet::join('species as s', 's.id', 'pets.species_id')
        //             ->join('users as u', 'u.id', 'pets.user_id')
        //             ->select('pets.id',
        //                 'pets.code',
        //                 'pets.name',
        //                 'pets.breed',
        //                 'pets.zootechnical_function',
        //                 'pets.status',
        //                 'pets.image',
        //                 'pets.updated_at',
        //                 'pets.user_id',
        //                 's.name as common_name',
        //                 's.scientific_name',
        //                 'u.name as user_name')
        //             ->where(function($query){
        //                 $query->where('pets.code' , 'like', '%' . $this->search . '%')
        //                     ->orWhere('pets.name' , 'like', '%' . $this->search . '%')
        //                     ->orWhere('pets.breed' , 'like', '%' . $this->search . '%')
        //                     ->orWhere('pets.zootechnical_function' , 'like', '%' . $this->search . '%')
        //                     ->orWhere('pets.status' , 'like', '%' . $this->search . '%')
        //                     ->orWhere('s.name' , 'like', '%' . $this->search . '%')
        //                     ->orWhere('u.name' , 'like', '%' . $this->search . '%')
        //                     ->orWhere('s.scientific_name' , 'like', '%' . $this->search . '%');
        //             })
        //             ->orderBy($this->sort, $this->direction)
        //             ->orderBy('u.name', $this->direction)
        //             ->paginate($this->paginate);
        //     } else {
        //         $pets = Pet::join('species as s', 's.id', 'pets.species_id')
        //             ->join('users as u', 'u.id', 'pets.user_id')
        //             ->select('pets.id',
        //                 'pets.code',
        //                 'pets.name',
        //                 'pets.breed',
        //                 'pets.zootechnical_function',
        //                 'pets.status',
        //                 'pets.image',
        //                 'pets.updated_at',
        //                 'pets.user_id',
        //                 's.name as common_name',
        //                 's.scientific_name',
        //                 'u.name as user_name')
        //             ->orderBy($this->sort, $this->direction)
        //             ->orderBy('u.name', $this->direction)
        //             ->paginate($this->paginate);
        //     }
        // } else {
        //     $pets = [];
        // }

        return view('livewire.pet.component', ['pets' => $this->pets])
            ->extends('admin.layout.app')
            ->section('content');
    }
}
