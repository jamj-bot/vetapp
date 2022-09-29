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
                        //'v.type as type', // virus inactiva, arn mensajero
                        'v.manufacturer as manufacturer',
                        //'v.description as description',
                        'v.status as status')
                        //'v.dosage as dosage',
                        //'v.administration as administration',
                        //'v.vaccination_schedule',
                        //'v.primary_doses',
                        //'v.revaccination_doses',
                        //'v.revaccination_schedule')
                    ->orderBy('done', 'asc')
                    ->get();
                    // ->paginate($this->paginate);

        $pdf = PDF::loadView('admin.exports.pdf.vaccinationsPDF', compact('vaccinationsPDF', 'petPDF'))->setPaper('a4', 'landscape');
        return $pdf->stream('Vaccinations.pdf');
    }

    public function dewormingsPDF($pet)
    {
        $petPDF = Pet::findOrFail($pet);

        $dewormingsPDF = $petPDF->dewormings()
                    ->join('parasiticides as p', 'p.id', 'dewormings.parasiticide_id')
                    ->select('dewormings.id',
                        'dewormings.type',
                        'dewormings.duration',
                        'dewormings.withdrawal_period',
                        'dewormings.dose_number',
                        'dewormings.doses_required',
                        'dewormings.created_at',
                        'dewormings.updated_at',
                        'p.name as name',
                        'p.manufacturer as manufacturer',
                        'p.type as type_1',
                        'p.description as description',
                        'p.dose as dose',
                        'p.administration as administration',
                        'p.primary_application',
                        'p.primary_doses',
                        'p.reapplication_doses',
                        'p.reapplication_interval')
                    ->orderBy('dewormings.updated_at', 'asc')
                    ->get();


        $pdf = PDF::loadView('admin.exports.pdf.dewormingsPDF', compact('dewormingsPDF', 'petPDF'))->setPaper('a4', 'landscape');
        return $pdf->stream('Dewormings.pdf');
    }
}
