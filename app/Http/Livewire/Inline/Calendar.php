<?php

namespace App\Http\Livewire\Inline;

use App\Models\Appointment;
use App\Models\User;
use Livewire\Component;

class Calendar extends Component
{
    public $user;
    public $veterinarian;
    public $events = [];

    public function mount()
    {
        $this->veterinarian = $this->user->veterinarian->id;
    }

    public function render()
    {
        $appointments = Appointment::where('veterinarian_id', $this->veterinarian)->with(['veterinarian', 'user'])->get();

        foreach ($appointments as $appointment) {
            if (!$appointment->start_time) {
                continue;
            }

            // $time = 0;
            // $services = '';

            // foreach($appointment->serviceBookeds as $serviceBooked) {
            //     // dd($appointment->services);
            //     //$time += $serviceBooked->service->duration;
            //     $services .= ' / '. $serviceBooked->service->service_name;
            // }

            $this->events[] = [
                'title'           => $appointment->user->name . ' | ' . $appointment->allServices,
                'start'           => $appointment->start_time,
                'end'             => $appointment->end_time_expected,
                'backgroundColor' => $appointment->color,
                'url'             => route('admin.users.show', [$appointment->user, $appointment]),
            ];
        }

        return view('livewire.inline.calendar');
    }
}
