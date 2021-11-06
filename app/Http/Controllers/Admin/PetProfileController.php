<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Pet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PetProfileController extends Controller
{
    use AuthorizesRequests;

    public function show(Pet $pet)
    {
        $consultations_quantity = Consultation::where('pet_id', $pet->id)->count();
        $open_consultations_quantity = Consultation::where('pet_id', $pet->id)->where('consult_status', '<>', 'Closed')->count();

        //$this->authorize('pet_profile_show');
        return view('admin.pets.show', compact('pet', 'consultations_quantity', 'open_consultations_quantity'));
    }
}
