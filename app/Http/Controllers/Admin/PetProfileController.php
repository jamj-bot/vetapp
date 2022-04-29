<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Image;
use App\Models\Pet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PetProfileController extends Controller
{
    use AuthorizesRequests;

    public function show(Pet $pet)
    {
        $this->authorize('pets_show');

        $total_consultations = Consultation::withTrashed()
            ->where('pet_id', $pet->id)
            ->count();

        $trashed_consultations = Consultation::onlyTrashed()->where('pet_id', $pet->id)
            ->count();

        $closed_consultations = Consultation::where('pet_id', $pet->id)
            ->where('consult_status', '=', 'Closed')
            ->count();

        $open_consultations = Consultation::where('pet_id', $pet->id)
            ->where('consult_status', '<>', 'Closed')
            ->count();

        $weights_chart = Consultation::where('pet_id', $pet->id)
            ->get();


        //$this->authorize('pet_profile_show'); 'Lab tests pending','Radiology tests pending','Closed'
        return view('admin.pets.show',
            compact('pet',
                'trashed_consultations',
                'total_consultations',
                'closed_consultations',
                'open_consultations',
                'weights_chart'
            )
        );
    }
}
