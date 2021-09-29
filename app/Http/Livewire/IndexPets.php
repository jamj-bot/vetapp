<?php

namespace App\Http\Livewire;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;


class IndexPets extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Receiving parameter
    public $user;

    // Attributes to datatable
    public $paginate = '50', $sort = 'name', $direction = 'asc', $readyToLoad = false, $search = '', $filter = 'Alive';

    // Listeners: evento desde StorePets cuando creo nuevo registro
    protected $listeners = [
        'refresh-index-pets' => 'render'
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

    public function render()
    {
        if ($this->readyToLoad) {
            if (strlen($this->search) > 0) {
                $pets = $this->user->pets()->where('status', $this->filter)
                    ->where(function($query){
                        $query->where('code' , 'like', '%' . $this->search . '%')
                            ->orWhere('name' , 'like', '%' . $this->search . '%')
                            ->orWhere('status' , 'like', '%' . $this->search . '%')
                            ->orWhere('species_id' , 'like', '%' . $this->search . '%');
                    })
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            } else {
                 $pets = $this->user->pets()->where('status', $this->filter)
                    ->orderBy($this->sort, $this->direction)
                    ->simplePaginate($this->paginate);
            }
        } else {
            $pets = [];
        }

        return view('livewire.index-pets', compact('pets'));
    }
}
