<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;


class PermissionController extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Datatble attributes
    public $paginate = '25', $sort = 'name', $direction = 'asc', $search = '';

    // Component attributes
    public $pageTitle, $modalTitle;

    // CRUD attributes
    public $name, $selected_id;

    // Listener
    protected $listeners = [
        'destroy'
    ];

    // Query string to  urls with datatable filters
    protected $queryString = [
        'search' => ['except' => ''],
        'paginate' => ['except' => '25'],
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
            'name' => "required|min:3|max:255|unique:permissions,name,{$this->selected_id}"
        ];
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
        $this->pageTitle = 'Permissions';
        $this->modalTitle = 'Permission';
    }

    public function render()
    {
        $this->authorize('permissions_index');

        if (strlen($this->search) > 0) {
            $permissions = Permission::where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort, $this->direction)
                ->simplePaginate($this->paginate);
        } else {
            $permissions = Permission::orderBy($this->sort, $this->direction)
                ->simplePaginate($this->paginate);
        }

        return view('livewire.permission.component', compact('permissions'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function store()
    {
        $this->authorize('permissions_store');

        $validatedData = $this->validate();
        Permission::create($validatedData);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Permission has been stored correctly! You can find it in the permissions list.'
        ]);
    }

    public function edit(Permission $permission)
    {
        $this->selected_id = $permission->id;
        $this->name = $permission->name;

        $this->emit('show-modal', 'show-modal');
    }


    public function update()
    {
        $this->authorize('permissions_update');

        $validatedData = $this->validate();
        $permission = Permission::find($this->selected_id);
        $permission->update($validatedData);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Permission has been updated correctly.'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('permissions_destroy');

        $rolesCount = Permission::find($id)->getRoleNames()->count();

        if ($rolesCount > 0) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'This permission cannot be removed because has associated roles.'
            ]);
            return;
        }

        Permission::find($id)->delete();
    }

    function resetUI() {
        $this->selected_id = '';
        $this->name = '';
        $this->resetValidation();
        $this->resetPage();
    }
}
