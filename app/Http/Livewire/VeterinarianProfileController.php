<?php

namespace App\Http\Livewire;

use App\Models\User;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
// use Livewire\WithPagination;

class VeterinarianProfileController extends Component
{
    // use AuthorizesRequests;
    // use WithPagination;

    public $user;

    // General attributes
    public $pageTitle, $modalTitle;

    public function mount($user)
    {
        $this->pageTitle = 'Veterinarians';
        $this->modalTitle = "Veterinarian";
        $this->user = User::findOrFail($user);
    }
    public function render()
    {
        abort_if(! $this->user->hasRole('Veterinarian'), 404);

        return view('livewire.veterinarian.veterinarian-profile.component', [
                // 'users' => $this->users,
                'veterinariana' => $this->user,
            ])
            ->extends('admin.layout.app')
            ->section('content');
    }
}
