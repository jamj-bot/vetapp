<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class VeterinarianController extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Datatble attributes
    public $paginate = '50',
        $sort        = 'name',
        $direction   = 'asc',
        $search      = '',
        $readyToLoad = false,
        $selected    = [],
        $deleted     = [],
        $select_page = false;

    // General attributes
    public $pageTitle, $modalTitle;

    // CRUD attributes
    public $name,
        $phone,
        $email,
        $password,
        $password_confirmation,
        $status      = 'choose',
        $user_type   = 'choose',
        $selected_id = null;

    // Listeners
    protected $listeners = [
        'destroy' => 'destroy',
    ];

    /**
     *  Query string than  urls with datatable filters
     *
     **/
    protected $queryString = [
        'search'    => ['except' => ''],
        'paginate'  => ['except' => '50'],
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
            'name'                  => ['required', 'string', 'min:3', 'max:255'],
            'phone'                 => ['required', 'regex:/[0-9]{10}/'],
            'email'                 => ['required', 'email', "unique:users,email,{$this->selected_id}"],
            'password'              => [
                                            Rule::when($this->selected_id != null , ['nullable']),
                                            Rule::when($this->selected_id == null , ['required']),
                                            'string',
                                            'min:8',
                                            'confirmed'
                                        ],
            'password_confirmation' => [
                                            Rule::when($this->selected_id != null, ['nullable']),
                                            Rule::when($this->selected_id == null , ['required']),
                                            'string',
                                            'min:8'
                                        ],
            'user_type'             => ['required', 'not_in:choose'],
            'status'                => ['required', 'not_in:choose']
        ];
    }

    /**
     *  Check all items
     *
    **/
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->users->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->pageTitle = 'Veterinarians';
        $this->modalTitle = 'Veterinarian';
    }

    public function getUsersProperty()
    {
        if ($this->readyToLoad) {
            return User::with("veterinarian")
            ->when(strlen($this->search) > 0, function ($query) {
                $query->where('name', 'like', '%' . $this->search .'%')
                    ->orWhere('user_type', 'like', '%' . $this->search .'%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
                })
                ->role('Veterinarian')
                ->with('veterinarian')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        } else {
            return [];
        }
    }

    public function getRolesProperty()
    {
        return Role::select('name')->orderBy('id', 'asc')->get();
    }

    public function render()
    {
        $this->authorize('users_index');

        return view('livewire.veterinarian.component', [
                'users' => $this->users,
                'roles' => $this->roles,
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
        $this->authorize('users_store');

        $validatedData = $this->validate();
        $user = User::create([
            'name'      => $this->name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'password'  => bcrypt($this->password),
            'status'    => $this->status,
            'user_type' => $this->user_type
        ]);

        // Se asigna el rol que el usuario haya seleccionado en el campo profile
        $user->syncRoles($this->user_type);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('stored', [
            'title'    => 'Created',
            'subtitle' => 'Succesfully!',
            'class'    => 'bg-primary',
            'icon'     => 'fas fa-plus fa-lg',
            'image'    => auth()->user()->profile_photo_url,
            'body'     => '¡User has been stored correctly! You can find it in the user list.'
        ]);

        session()->flash('user_id', $user->id);
        session()->flash('message', 'Saved.');
    }

    public function edit(User $user)
    {
        $this->selected_id           = $user->id;
        $this->name                  = $user->name;
        $this->phone                 = $user->phone;
        $this->email                 = $user->email;
        $this->password              = '';
        $this->password_confirmation = '';
        $this->status                = $user->status;
        $this->user_type             = $user->user_type; #user->role->name

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('users_update');

        $validatedData = $this->validate();
        $user = User::find($this->selected_id);

        /**
            caso de uso:
                -actualizar la información del usuario sin tener que cambiar la contraseña
                    la contraseña se debe dejar en blanco.
                -actualizar la información del usuario cambiando la contraseña
                    la contraseña no se puede dejar en blanco.


            if (Hash::check($this->password, $user->password)) {
                // Correct password...
            }
        **/
            $user->update([
                'name'      => $this->name,
                'phone'     => $this->phone,
                'email'     => $this->email,
                'password'  => $this->password != null? bcrypt($this->password) : $user->password,
                'status'    => $this->status,
                'user_type' => $this->user_type
            ]);

            $user->syncRoles($this->user_type); // Se asigna el rol que el usuario haya seleccionado en el campo profile

            $this->emit('hide-modal', 'hide-modal');

            $this->resetUI();

            $this->dispatchBrowserEvent('updated', [
                'title'    => 'Updated',
                'subtitle' => 'Succesfully!',
                'class'    => 'bg-success',
                'icon'     => 'fas fa-check-circle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => 'User information has been updated.'
            ]);

            session()->flash('user_id', $user->id);
            session()->flash('message', 'Updated.');
    }

    public function destroy($id)
    {
        $this->authorize('user_destroy');

        User::find($id)->delete();

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
        $this->authorize('user_destroy');

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

            $deletedtems = User::whereIn('id', $this->selected)
                ->select('name')
                ->pluck('name')
                ->toArray();

            User::destroy($this->selected);

            $this->dispatchBrowserEvent('deleted', [
                'title'    => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class'    => 'bg-danger',
                'icon'     => 'fas fa-check-circle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => count($deletedtems). ' items moved to Recycle bin: ' . implode(", ", $deletedtems)
            ]);
        }

        $this->resetUI();
    }

    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);

        // Restaura los ids contenidos en la última posición del array
        User::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = User::whereIn('id', $this->deleted[$last])
            ->select('name')
            ->pluck('name')
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

    function resetUI() {
        $this->selected_id = null;
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->status = 'choose';
        $this->user_type = 'choose';

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
