<?php

namespace App\Http\Livewire\Inline;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use App\Models\Veterinarian;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class Appointments extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Receiving Parameter
    public $user;

    // Datatable attributes
    public $paginate = '50',
        $sort = 'updated_at',
        $direction = 'desc',
        $readyToLoad = false,
        $search = '',
        $from = null,
        $to = null,
        $selected = [],
        $deleted = [],
        $select_page = false;

    // Datatable attributes ¿sirve para algo el size = 1?
    public $selected_services = [],
        $veterinarian_id = 'choose',
        $start_time = null,
        $end_time_expected = null,
        $selected_id,
        $size = 1;

   // General component attrbibutes
    public $pageTitle, $modalTitle;

    // Listeners
    protected $listeners = [
        // 'destroyAppointment' => 'destroy',
        'refresh-appointments' => 'resetUI'
    ];

    /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'veterinarian_id'     => 'required|not_in:choose',
            'start_time'          => 'required|date|after_or_equal:' . date('d-m-Y H:i:s'),
            // 'end_time_expected'   => "required|date|after:start_time",
            'selected_services'   => 'sometimes|array|min:1',
            'selected_services.*' => 'required|exists:services,id'
        ];
    }

    /**
     *  Real time validation
     *
    **/
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     *  Check or all function
     *
    **/
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->appointments->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedStartTime()
    {
        $now = strtotime($this->start_time);
        $next_five = ceil($now/300)*300;
        $this->start_time = date('d-m-Y H:i', $next_five);
    }

    /**
     *  Reset the pagination while search property is updated
     *  and reset select_page and selected properties is updated
     *
    **/
    public function updatingSearch()
    {
        $this->resetPage();

        // Al escribir en el buscador, se limpian los items seleccionados
        $this->select_page = false;
        $this->selected = [];
    }

    /**
     *  Funtion to reset pagination when a filter changes
     *
    **/
    public function resetPagination()
    {
        $this->resetPage();
    }

    /**
     * Function para seleccionar el orden de los datos
     *
    **/
    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    /**
     *  function para verificar si la página ya se cargó.
     *
    **/
    public function loadItems()
    {
        $this->readyToLoad = true;
    }

    public function mount()
    {
        $this->pageTitle = 'Appointments';
        $this->modalTitle = 'Appointment';
    }

    // public function showOptions()
    // {
    //     $this->size = 4;
    // }


    public function getVeterinariansProperty()
    {
        return User::role('veterinarian')->select('id', 'name')->get();
    }

    public function getAppointmentsProperty()
    {
        if ($this->readyToLoad) {
            return $this->user->appointments()->with('services:service_name')
                ->when(strlen($this->search) > 0, function ($query) {
                    $query->whereHas('services', function ($query) {
                        $query->where('service_name', 'like', '%'. $this->search .'%');
                    })
                    ->orWhereHas('veterinarian.user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        } else {
            return [];
        }
    }

    public function getServicesListProperty()
    {
        return Service::all();
    }

    public function render()
    {
        $this->authorize('appointments_index');
        //$appointments = $this->user->appointments->where('canceled', '0')->where('start_time', '>', Carbon::now())->sortBy('start_time');
        return view('livewire.inline.appointments', [
            'appointments' => $this->appointments,
            'veterinarians' => $this->veterinarians,
            'services_list' => $this->services_list
        ]);
    }


    public function submit()
    {
        if ($this->selected_id) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->authorize('appointments_store');

        $appointment_duration = Service::whereIn('id', $this->selected_services)->select('duration')->sum('services.duration');
        $this->end_time_expected = new Carbon($this->start_time);
        $this->end_time_expected = $this->end_time_expected->addMinutes($appointment_duration)->subSeconds(1);
        $this->start_time_tmp = new Carbon($this->start_time);


        $appointmentExists = Appointment::whereBetween('start_time',[$this->start_time_tmp, $this->end_time_expected])
            ->orWhereBetween('end_time_expected',[$this->start_time_tmp, $this->end_time_expected])
            ->orWhere(function ($query) {
                $query->where('start_time','<=',$this->start_time_tmp)
                    ->where('end_time_expected','>=',$this->end_time_expected);
            })->exists();


        if ($appointmentExists) {
            session()->flash('message', 'There is already an appointment that overlaps with the appointment you are trying to save.');
        }

        if (!$appointmentExists) {

            try {
                DB::transaction(function () {

                    $validatedData = $this->validate(); // validad appointment

                    $appointment = Appointment::create([
                        'user_id' => $this->user->id,
                        'veterinarian_id' => $this->veterinarian_id,
                        'start_time' => $this->start_time,
                        'end_time_expected' => $this->end_time_expected
                    ]);

                    $appointment->services()->attach($this->selected_services);

                });

                 $this->dispatchBrowserEvent('storedAppointment', [
                    'title'    => 'Stored',
                    'subtitle' => 'Succesfully!',
                    'class'    => 'bg-success',
                    'icon'     => 'fas fa-check-circle fa-lg',
                    'image'    => auth()->user()->profile_photo_url,
                    'body'     => 'Appointment has been stored.'
                ]);

                $this->emit('hide-modal-appointment', 'hide-modal-appointment');
                $this->resetUI();

            } catch (Exception $e) {
                // Aquí puedes mandar un flash message al usuario con el mensaje de error
                session()->flash('error', $e->getMessage());
            }
        }
    }

    public function edit(Appointment $appointment)
    {
        $this->selected_services = $appointment->services->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        $this->selected_id = $appointment->id;
        $this->veterinarian_id = $appointment->veterinarian->id;
        $this->start_time = $appointment->start_time->format('d-m-Y H:i');
        $this->emit('show-modal-appointment', 'show-modal-appointment');
    }

    public function update()
    {
        $this->authorize('appointments_update');

        $appointment_duration = Service::whereIn('id', $this->selected_services)->select('duration')->sum('services.duration');
        $this->end_time_expected = new Carbon($this->start_time);
        $this->end_time_expected = $this->end_time_expected->addMinutes($appointment_duration)->subSeconds(1);
        $this->start_time_tmp = new Carbon($this->start_time);


        // $appointmentExists = Appointment::whereBetween('start_time',[$this->start_time_tmp, $this->end_time_expected])
        //     ->orWhereBetween('end_time_expected',[$this->start_time_tmp, $this->end_time_expected])
        //     ->orWhere(function ($query) {
        //         $query->where('start_time','<=',$this->start_time_tmp)
        //             ->where('end_time_expected','>=',$this->end_time_expected);
        //     })
        //     ->where('id', '!=', $this->selected_id)
        //     ->exists();

        $appointmentExists = Appointment::where(function ($query) {
            $query->whereBetween('start_time', [$this->start_time_tmp, $this->end_time_expected])
                ->orWhereBetween('end_time_expected', [$this->start_time_tmp, $this->end_time_expected])
                ->orWhere(function ($query) {
                    $query->where('start_time', '<=', $this->start_time_tmp)
                        ->where('end_time_expected', '>=', $this->end_time_expected);
                });
            })->where('id', '!=', $this->selected_id)->exists();

        if ($appointmentExists) {
            session()->flash('message', 'There is already an appointment that overlaps with the appointment you are trying to save.');
        }

        if (!$appointmentExists) {

            try {
                DB::transaction(function () {

                    $validatedData = $this->validate();

                    $appointment = Appointment::find($this->selected_id);
                    $appointment->update($validatedData);
                    $appointment->services()->sync($this->selected_services);
                });

                $this->dispatchBrowserEvent('updatedAppointment', [
                    'title'    => 'Updated',
                    'subtitle' => 'Succesfully!',
                    'class'    => 'bg-success',
                    'icon'     => 'fas fa-check-circle fa-lg',
                    'image'    => auth()->user()->profile_photo_url,
                    'body'     => 'Appointment has been updated.'
                ]);

                $this->emit('hide-modal-appointment', 'hide-modal-appointment');
                $this->resetUI();

            } catch (Exception $e) {
                session()->flash('error', $e->getMessage());
            }
        }
    }

    public function destroy($id)
    {
        $this->authorize('appointmets_destroy');

        $appointment = Appointment::findOrFail($id);

        $appointment->delete();

        $this->dispatchBrowserEvent('deletedAppointment', [
            'title'    => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class'    => 'bg-danger',
            'icon'     => 'fas fa-check-circle fa-lg',
            'image'    => auth()->user()->profile_photo_url,
            'body'     => $appointment->start_time . ' has been deleted.'
        ]);

        $this->resetUI();
        $this->emit('refresh-dumpster');
    }

    public function destroyMultiple()
    {
        $this->authorize('appointments_destroy');

        //Si no hay ningun item seleccionado
        if (!$this->selected) {
            $this->dispatchBrowserEvent('destroy-error', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-light',
                'icon' => 'fas fa-exclamation-triangle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => '0 items selected'
            ]);
            return;
        }

        // Eliminando los items que sí se pueden borrar
        if ($this->selected) {
            // Agregando al array $deleted aquellos que items que sí se pueden borrar
            $this->pushDeleted();

            $deletedtems = Appointment::whereIn('id', $this->selected)
                ->select('id')
                ->pluck('id')
                ->toArray();

            Appointment::destroy($this->selected);

            $this->dispatchBrowserEvent('deleted', [
                'title' => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-danger',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => count($deletedtems). ' items moved to Recycle bin: ' . implode(", ", $deletedtems)
            ]);
        }

        $this->resetUI();
        $this->emit('refresh-dumpster');
    }

    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);

        // Restaura los ids contenidos en la última posición del array
        Appointment::onlyTrashed()
            ->whereIn('id', $this->deleted[$last])
            ->restore();

        $restoredItems = Appointment::whereIn('id', $this->deleted[$last])
            ->select('id')
            ->pluck('id')
            ->toArray();

        $this->dispatchBrowserEvent('restored', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => count($restoredItems). ' items restored: ' . implode(", ", $restoredItems)
        ]);

        // Elimina el último elemento del array de arrays
        unset($this->deleted[$last]);
    }

    /**
     * Inserta un nuevo array de ids en el array $deleted;
     *
    **/
    public function pushDeleted($id = null)
    {
        if ($id) {
            $this->selected = [$id];
        }

        if (count($this->deleted) < 10) {
            array_push($this->deleted, $this->selected);
        } elseif (count($this->deleted) == 10) {
            unset($this->deleted[0]);
            array_push($this->deleted, $this->selected);
        }
    }

    public function resetUI()
    {
        $this->selected_id = null;
        $this->veterinarian_id = 'choose';
        $this->start_time = null;
        $this->end_time = null;
        $this->selected_services = [];
        $this->size = 1;

        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
