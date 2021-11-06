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
    public $paginate = '25', $sort = 'name', $direction = 'asc', $search = '';

    // Component attributes
    public $pageTitle;

    // Model attributes
    public $role_id, $permissionSelected = [], $oldPermissions = [];

    // Listener
    public $listeners = [
        'revokeAll' => 'revokeAll'
    ];

    // Query string to  urls with datatable filters
    protected $queryString = [
        'search' => ['except' => ''],
        'paginate' => ['except' => '25'],
        'sort' => ['except' => 'name'],
        'direction' => ['except' => 'asc']
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

    public function mount()
    {
        $this->pageTitle = 'Assign Permissions';
        $this->role_id = 'choose';
    }

    public function render()
    {
        $this->authorize('assign_permissions_index');

        // recupero todos los permisos seleccionando nombre, id y agregando un nuevo campo llamado checked con valor de 0
        $permissions = Permission::select('name', 'id', DB::raw("0 as checked"))
            ->orderBy($this->sort, $this->direction)
            ->simplePaginate($this->paginate);


        // Si el usuario tiene seleccionado un rol:
            // Uno las tablas role_has_permisions através del id del permiso, cuando el role id y los guardo en un array.
        if ($this->role_id != 'choose') {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                ->where('role_id', $this->role_id)
                ->pluck('permissions.id')
                ->toArray();

            $this->oldPermissions = $list;
        }

        // Si el usuario tiene seleccionado un rol:
            // Para cada permission
                //Busco el rol que coincida con el rol releccionado
                // Verifico si el rol tiene el permiso
                    // Si el rol tiene permiso, entonces, el campo checked se vulve 1, en caso contrario queda igual
        if ($this->role_id != 'choose') {
            foreach ($permissions as $permission) {
                $role = Role::find($this->role_id);
                $hasPermission = $role->hasPermissionTo($permission->name);
                if ($hasPermission) {
                    $permission->checked = 1;
                }
            }
        }

        $roles = Role::orderBy('id', 'asc')->get();

        return view('livewire.assign-permissions.component', compact('roles', 'permissions'))
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
