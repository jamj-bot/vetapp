<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function show(Pet $pet)
    {
        //$this->authorize('pet_profile_show');
        return view('admin.consultations.show', compact('pet'));
    }
}
