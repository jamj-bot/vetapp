<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PetProfileController extends Controller
{
    use AuthorizesRequests;

    public function show(Pet $pet)
    {
        //$this->authorize('pet_profile_show');
        return view('admin.pets.show', compact('pet'));
    }
}
