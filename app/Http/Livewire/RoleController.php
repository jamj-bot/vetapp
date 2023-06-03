<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleController extends Component
{

    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Attributes to datatable
    public $paginate = '5', $sort = 'name', $direction = 'asc', $search = '';

    // General attrbibutes to component
    public $pageTitle, $modalTitle;

    // Attributes to CRUD
    public $name, $selected_id;

    // Listener
    protected $listeners = [
        'destroy'
    ];

    // Query string to  urls with datatable filters
    protected $queryString = [
        'search' => ['except' => ''],
        'paginate' => ['except' => '5'],
        'sort' => ['except' => 'name'],
        'direction' => ['except' => 'asc']
    ];

     /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'name' => "required|string|max:140|unique:roles,name,{$this->selected_id}"
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


    public function mount()
    {
        $this->pageTitle = 'Roles';
        $this->modalTitle = 'Role';
    }

    public function render()
    {
        $this->authorize('roles_index');

        if (strlen($this->search) > 0) {
            $roles = Role::where('name', 'like', '%' . $this->search. '%')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        } else {
            $roles = Role::orderBy($this->sort, $this->direction)
                ->simplePaginate($this->paginate);
        }

        return view('livewire.role.component', compact('roles'))
            ->extends('admin.layout.app')
            ->section('content');
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
        $this->authorize('roles_store');

        $validatedData = $this->validate();
        Role::create($validatedData);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Role has been stored correctly! You can find it in the roles list.'
        ]);
    }

    public function edit(Role $role)
    {
        $this->selected_id = $role->id;
        $this->name = $role->name;

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('roles_update');

        $validatedData = $this->validate();
        $role = Role::find($this->selected_id);
        $role->update($validatedData);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Role has been updated correctly.'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('roles_destroy');

        Role::find($id)->delete();
    }

    function resetUI() {
        $this->selected_id = '';
        $this->name = '';
        $this->resetValidation();
        $this->resetPage();
    }
}
