<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Pet;
use Livewire\Component;

class ConsultationDetailsController extends Component
{

    public $pageTitle;
    public $pet, $consultation_id, $selected_consultation_id = null, $show = null, $retrieved_consultation;

    /**
     *  function para verificar si la página ya se cargó.
     *
    **/
    public function loadItems()
    {
        $this->readyToLoad = true;
    }

    public function mount($pet, $consultation)
    {

        $this->pet = Pet::findOrFail($pet);
        $this->consultation_id = $consultation;

        $this->pageTitle = 'Consultation';
    }

    public function render()
    {
        // el usuario no ha seleccionado un id
        if ($this->selected_consultation_id == null) {
            // muestro la consulta con el id que se envió a través de la url
            $consultation = Consultation::findOrFail($this->consultation_id);

            $this->retrieved_consultation = $consultation; // retrieved consultation es la consulta recuperada actualmente
        } elseif ($this->selected_consultation_id != null) {
            if ($this->show != null) {
                if ($this->show == 'next') {
                    // muestro la siguiente consulta rekacionada respecto a la consulta recuperada actualment
                    // $pet = Pet::findOrFail($this->pet_id);

                    $consultation = $this->pet->consultations()
                        ->orderBy('updated_at', 'asc')
                        ->where('updated_at', '>', $this->retrieved_consultation->updated_at)
                        ->first();

                    if ($consultation == null) {
                        $consultation = $this->pet->consultations()
                            ->orderBy('updated_at', 'asc')
                            ->first();
                    }

                    $this->retrieved_consultation = $consultation; // retrieved consultation es la consulta recuperada actualmente
                } elseif ($this->show == 'previous') {
                    // muestro la consulta anterior rekacionada respecto a la consulta recuperada actualment
                    // $pet = Pet::findOrFail($this->pet_id);
                    $consultation = $this->pet->consultations()
                        ->orderBy('updated_at', 'desc')
                        ->where('updated_at', '<', $this->retrieved_consultation->updated_at)
                        ->first();

                    if ($consultation == null) {
                        if ($consultation == null) {
                            $consultation = $this->pet->consultations()
                                ->orderBy('updated_at', 'desc')
                                ->first();
                        }
                    }

                    $this->retrieved_consultation = $consultation; // retrieved consultation es la consulta recuperada actualmente
                }
            }

        }


        // ERROR 4040 cuando la consulta no pertenece a la mascota
        if ($consultation->pet->id != $this->pet->id) {
            abort(404);
        }

        return view('livewire.consultation.details.component', compact('consultation'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function previusConsultation($id)
    {
        $this->selected_consultation_id = $id;
        $this->show = 'previous';
        // $pet = Pet::findOrFail($this->pet_id);
        // $previus_consultation = $pet->consultations()->orderBy('updated_at', 'desc')->where('updated_at', '<', $consultation->updated_at)->first();
        // dd($previus_consultation);
    }

    public function nextConsultation($id)
    {
        $this->selected_consultation_id = $id;
        $this->show = 'next';
        // $pet = Pet::findOrFail($this->pet_id);
        // $next_consultation = $pet->consultations()->orderBy('updated_at', 'asc')->where('updated_at', '>', $consultation->updated_at)->first();
        // dd($next_consultation);
    }

}
