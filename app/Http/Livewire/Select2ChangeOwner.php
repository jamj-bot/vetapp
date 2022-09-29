<?php

namespace App\Http\Livewire;

use App\Models\Pet;
use App\Models\User;
use Livewire\Component;

class Select2ChangeOwner extends Component
{
    public $users, $userIdSelected, $userNameSelected, $search = '';

    // Receiving parameter
    public $pet, $user;

    public function mount()
    {
        $this->users = [];
    }

    protected $rules = [
        'userNameSelected' => 'required',
        'userIdSelected' => 'required|exists:users,id'
    ];



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $this->users = User::where('status', 'active')
            ->where('id', '!=', $this->user->id)
            ->get();

        return view('livewire.select2-change-owner');
    }


    public function changeOwner()
    {
        $validatedData = $this->validate();

        $pet = Pet::findOrFail($this->pet->id);
        $user = User::findOrFail($pet->user_id); // owner original
        $pet->user_id = $this->userIdSelected; // asigno nuevo owner
        $pet->save();
        return redirect()->route('admin.users.show', ['user' => $user]); //redirijo al owner original
    }


    public function resetUI()
    {
        $this->userIdSelected = null;
        $this->userNameSelected = null;
        $this->resetValidation();
    }
}
