<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Pet;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    function consultationPDF($pet, $consultation)
    {
        $petPDF = Pet::findOrFail($pet);
        $consultationPDF = Consultation::findOrFail($consultation);

        $pdf = PDF::loadView('admin.exports.pdf.consultationPDF', compact('consultationPDF', 'petPDF'));
        return $pdf->stream('Consultation-' . $consultationPDF->id . '-' . $consultationPDF->pet->name . '-' . Carbon::now()->format('his') . '.pdf');
        //return $pdf->download('Consultation.pdf');
    }



    public function vaccinationsPDF($pet)
    {
        $petPDF = Pet::findOrFail($pet);

        $vaccinationsPDF = $petPDF->vaccinations()
                    ->join('vaccines as v', 'v.id', 'vaccinations.vaccine_id')
                    ->select('vaccinations.id',
                        'vaccinations.type',
                        'vaccinations.batch_number',
                        'vaccinations.done',
                        'vaccinations.applied',
                        'vaccinations.dose_number',
                        'vaccinations.doses_required',
                        'v.name as name',
                        'v.manufacturer as manufacturer',
                        'v.description as description',
                        'v.primary_vaccination',
                        'v.primary_doses',
                        'v.revaccination_doses',
                        'v.revaccination_interval')
                    ->orderBy('done', 'asc')
                    ->get();
                    // ->paginate($this->paginate);

        $pdf = PDF::loadView('admin.exports.pdf.vaccinationsPDF', compact('vaccinationsPDF', 'petPDF'));
        return $pdf->stream('Vaccinations.pdf');
    }
}
