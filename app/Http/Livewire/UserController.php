<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;


class UserController extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Datatable attributes
    public $paginate = '10', $sort = 'name', $direction = 'asc', $readyToLoad = false, $search = '';

    // General attributes
    public $pageTitle, $modalTitle;

    // CRUD attributes
    public $name, $phone, $email, $password, $status, $user_type, $selected_id;

    // Listeners
    protected $listeners = [
        'destroy' => 'destroy',
    ];


    /**
     *  Query string than  urls with datatable filters
     *
     **/
    protected $queryString = [
        'search' => ['except' => ''],
        'paginate' => ['except' => '10'],
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
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|regex:/[0-9]{10}/',
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'password' => 'required|min:8',
            'user_type' => 'required|not_in:choose',
            'status' => 'required|not_in:choose'
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
        $this->pageTitle = 'Users';
        $this->modalTitle = "User";
    }

    public function render()
    {
        $this->authorize('users_index');
        //sleep(1);
        if ($this->readyToLoad) {
            if (strlen($this->search) > 0 ) {
                $users = User::where('name', 'like', '%' . $this->search .'%')
                    ->orWhere('user_type', 'like', '%' . $this->search .'%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);

            } else {
                $users = User::orderBy($this->sort, $this->direction)->paginate($this->paginate);
            }
        } else {
            $users = [];
        }

        $roles = Role::select('name')->orderBy('id', 'asc')->get();

        return view('livewire.user.component', compact('users', 'roles'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function store()
    {
        $this->authorize('users_store');

        $validatedData = $this->validate();
        $user = User::create($validatedData);

        // Se asigna el rol que el usuario haya seleccionado en el campo profile
        $user->syncRoles($this->user_type);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => '¡User has been stored correctly! You can find it in the user list.'
        ]);
    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->password = "";
        $this->status = $user->status;
        $this->user_type = $user->user_type;

        $this->emit('show-modal', 'show-modal');
    }

    public function update()
    {
        $this->authorize('users_update');

        $validatedData = $this->validate();
        $user = User::find($this->selected_id);

        $user->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'status' => $this->status,
            'user_type' => $this->user_type
        ]);

        //$user->update($validatedData);

        // Se asigna el rol que el usuario haya seleccionado en el campo profile
        $user->syncRoles($this->user_type);

        $this->emit('hide-modal', 'hide-modal');

        $this->resetUI();

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'User information has been updated correctly.'
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorize('users_destroy');
        $user->delete();
    }



    function resetUI() {
        $this->selected_id = '';
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->password = "";
        $this->status = 'choose';
        $this->user_type = 'choose';
        $this->resetValidation();
        $this->resetPage();
    }
}
