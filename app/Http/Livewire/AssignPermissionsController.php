<?php

namespace App\Http\Livewire;

use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionsController extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Datatable attributes
    //public $paginate = '50', $sort = 'name', $direction = 'asc', $search = '';

    // Component attributes
    public $pageTitle;

    // Model attributes
    public $paginate        = '50',
        $sort               = 'name',
        $direction          = 'asc',
        $search             = '',
        $role_id            = 0,
        $permissionSelected = [],
        $oldPermissions     = [],
        $readyToLoad        = false,
        $select_page        = false;

    // Listener
    public $listeners = [
        'revokeAll' => 'revokeAll'
    ];

    // Query string to  urls with datatable filters
    protected $queryString = [
        'search'    => ['except' => ''],
        'paginate'  => ['except' => '50'],
        'sort'      => ['except' => 'name'],
        'direction' => ['except' => 'asc']
    ];

    public function updatedSelectPage()
    {
        if ($this->select_page) {
            $this->syncAll();
        } else {
            $this->revokeAll();
        }
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

    public function mount()
    {
        $this->pageTitle = 'Assign Permissions';
        $this->role_id = 'choose';
    }

    public function getPermissionsProperty()
    {
        if ($this->readyToLoad) {
            if (strlen($this->search) > 0) {
                // Recupero los permisos buscados por le campo search
                return Permission::select('name', 'id', DB::raw("0 as checked"))
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            } else {
                // recupero todos los permisos seleccionando nombre, id y agregando un nuevo campo llamado checked con valor de 0
                return Permission::select('name', 'id', DB::raw("0 as checked"))
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            }
        } else {
            return [];
        }
    }

    public function getRolesProperty()
    {
        return Role::orderBy('id', 'asc')->get();
    }

    public function render()
    {
        $this->authorize('assign_permissions_index');

        /**
            1. Selecciona un role
            2. PARA todos los permissions
                2.1 VERIFICA si el $role seleccionado tiene asignado el permission actual
                2.2.SI es VERDAD
                    2.2.1. AGREGA al permission actueal el atributo checked y le asigna el valor 1.
        **/

        if ($this->role_id != 'choose') {
            $role = Role::find($this->role_id);
            foreach ($this->permissions as $permission) {
                $hasPermission = $role->hasPermissionTo($permission->name);
                if ($hasPermission) {
                    $permission->checked = 1;
                }
            }

            // Si el total de permisos es mayor que el total de permisos asignados
            if ( Permission::all()->count() > $role->permissions->count() ) {
                $this->select_page = false;
            } else {
                $this->select_page = true;
            }
        }

        return view('livewire.assign-permissions.component', [
            'roles' => $this->roles,
            'permissions' => $this->permissions
            ])
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function syncPermission($state, $permissionName)
    {
        $this->authorize('assign_permissions_sync');

        if ($this->role_id != 'choose') {
            $roleName = Role::find($this->role_id);

            if ($state) {
                $roleName->givePermissionTo($permissionName);

                $this->dispatchBrowserEvent('assigned', [
                    'title' => 'Assigned',
                    'subtitle' => 'Succesfully!',
                    'class' => 'bg-danger',
                    'icon' => 'fas fa-door-open fa-lg',
                    'image' => auth()->user()->profile_photo_url,
                    'body' => 'Permission has been assigned successfully'
                ]);

            } else {
                $roleName->revokePermissionTo($permissionName);

                $this->dispatchBrowserEvent('revoked', [
                    'title' => 'Revoked',
                    'subtitle' => 'Succesfully!',
                    'class' => 'bg-primary',
                    'icon' => 'fas fa-door-closed fa-lg',
                    'image' => auth()->user()->profile_photo_url,
                    'body' => 'Permission has been revoked successfully'
                ]);

            }

        } else {
            $this->dispatchBrowserEvent('error', [
                'title' => 'Error',
                'subtitle' => 'Error!',
                'class' => 'bg-light',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'Please select a valid role. There is no one selected to assign a permission to.'
            ]);
        }
    }


    public function revokeAll()
    {
        $this->authorize('assign_permissions_revoke_all');

        if ($this->role_id == 'choose') {
            $this->dispatchBrowserEvent('error', [
                'title' => 'Error',
                'subtitle' => 'Error!',
                'class' => 'bg-light',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'Please select a valid role. There is no one selected to assign a permission to.'
            ]);
            $this->select_page = false;
            return;
        }

        $role = Role::find($this->role_id);
        $role->syncPermissions([0]);

        $this->dispatchBrowserEvent('revoked', [
            'title' => 'Revoked',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-door-closed fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'All Permissions has been revoked successfully'
        ]);
    }

    public function syncAll()
    {
        $this->authorize('assign_permissions_sync_all');

        if ($this->role_id == 'choose') {
            $this->dispatchBrowserEvent('error', [
                'title' => 'Error',
                'subtitle' => 'Error!',
                'class' => 'bg-light',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'Please select a valid role. There is no one selected to assign a permission to.'
            ]);
            $this->select_page = false;
            return;
        }

        $role = Role::find($this->role_id);
        $permissions = Permission::pluck('id')->toArray();
        $role->syncPermissions($permissions);

        $this->dispatchBrowserEvent('assigned', [
            'title' => 'Assigned',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-door-open fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'All Permissions has been assigned successfully'
        ]);
    }
}
