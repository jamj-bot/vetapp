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
    public $paginate = '25',
        $sort        = 'name',
        $direction   = 'asc',
        $search      = '',
        $readyToLoad = false,
        $selected    = [],
        $deleted     = [],
        $select_page = false;

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
        'search'    => ['except' => ''],
        'paginate'  => ['except' => '25'],
        'sort'      => ['except' => 'name'],
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
     *  Check all items
     *
    **/
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->permissions->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->validateOnly($propertyName);
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
     *  Reset the pagination while search property is updated
     *  and reset select_page and selected properties is updated
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

    public function mount()
    {
        $this->pageTitle = 'Permissions';
        $this->modalTitle = 'Permission';
    }

    public function getPermissionsProperty()
    {
        if ($this->readyToLoad) {
            return Permission::where('name', 'like', '%' . $this->search . '%')
                ->with(['roles:name'])
                ->when(strlen($this->search) > 0, function ($query) {
                    $query->where('name', 'like', '%' . $this->search .'%');
                })->orWhereHas('roles', function ($query) {
                    $query->where('name', 'like', '%'. $this->search .'%');
                })->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        } else {
            return [];
        }
    }

    public function render()
    {
        $this->authorize('permissions_index');

        return view('livewire.permission.component', [
                'permissions' => $this->permissions,
            ])
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
                'title'    => 'Not deleted',
                'subtitle' => 'Warning!',
                'class'    => 'bg-warning',
                'icon'     => 'fas fa-exclamation-triangle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => 'This permission cannot be removed because has associated roles.'
            ]);
            $this->resetUI();
            return;
        }

        Permission::find($id)->delete();

        $this->pushDeleted($id);

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Item moved to Recycle bin.'
        ]);

        $this->resetUI();
    }

    public function destroyMultiple()
    {
        $this->authorize('permissions_destroy');

        //Si no hay items seleccionados
        if (!$this->selected) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-light',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => '0 items selected'
            ]);
            return;
        }

        // Eliminando del array $selected aquellos items que no se pueden borrar
        $notDeleted = [];
        foreach ($this->selected as $key => $id) {
            if (Permission::find($id)->roles->count()) {
                array_push($notDeleted, $id);
                unset($this->selected[$key]);
            }
        }

        if ($notDeleted) {
            $notDeletedItems = Permission::whereIn('id', $notDeleted)
                ->select('name')
                ->pluck('name')
                ->toArray();

            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => count($notDeletedItems) . ' items can’t be moved to Recycle bin because cannot be deleted: ' . implode(", ", $notDeletedItems)
            ]);
        }

        // Eliminando los items que sí se pueden borrar
        if ($this->selected) {
            // Agregando al array $deleted aquellos que items que sí se pueden borrar
            $this->pushDeleted();

            $deletedtems = Permission::whereIn('id', $this->selected)
                ->select('name')
                ->pluck('name')
                ->toArray();

            Permission::destroy($this->selected);

            $this->dispatchBrowserEvent('deleted', [
                'title' => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-danger',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => count($deletedtems). ' items moved to Recycle bin: ' . implode(", ", $deletedtems)
            ]);
        }

        $this->resetUI();
    }

    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);

        // Restaura los ids contenidos en la última posición del array
        Permission::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = Permission::whereIn('id', $this->deleted[$last])
            ->select('name')
            ->pluck('name')
            ->toArray();

        $this->dispatchBrowserEvent('restored', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => count($restoredItems). ' items restored: ' . implode(", ", $restoredItems)
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

    function resetUI() {
        $this->selected_id = '';
        $this->name = '';

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
