<?php

namespace App\Http\Livewire\Inline;

use App\Models\Appointment;
use App\Models\Deworming;
use App\Models\Image;
use App\Models\Pet;
use App\Models\Prescription;
use App\Models\Test;
use App\Models\Vaccination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class Dumpster extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Receiving parameter
    public $user;

    // Datatable attributes
    public $paginate = '50',
        $sort        = 'deleted_at',
        $direction   = 'desc',
        $search      = '',
        $readyToLoad = false,
        $model       = 'pets',
        $selected    = [],
        $deleted     = [],
        $select_page = false;

    // General attributes
    public $pageTitle, $modalTitle;

    // Listeners
    protected $listeners = [
        'destroy',
        'destroyMultiple',
        'refresh-dumpster' => 'resetUI'
    ];

    /**
     *  Check - Uncheck all items
     *
    **/
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->items->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->selected = [];
        }
    }

    /**
     *  uncheck Select All
     *
    **/
    public function updatedModel()
    {
        $this->select_page = false;
        $this->selected = [];
        $this->deleted = [];
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
        $this->pageTitle = 'Dumpsters';
        $this->modalTitle = 'Dumpster';
    }

    public function getItemsProperty()
    {
            // return $this->user->{$this->model}()->onlyTrashed()
            //     ->where('user_id', '=', $this->user->id)
            //     ->when($this->model == 'pets', function ($query) {
            //         $query->select('id', 'name', 'deleted_at', DB::raw("'$this->model' as model"));
            //     })
            //     ->when($this->model == 'appointments', function ($query) {
            //         $query->select('id', 'start_time', 'end_time_expected', 'deleted_at', DB::raw("'$this->model' as model"));
            //     })
            //     ->when(strlen($this->search) > 0, function ($query) {
            //         $query->where('name', 'like', '%' . $this->search . '%');
            //     })
            //     ->orderBy($this->sort, $this->direction)
            //     ->paginate($this->paginate);
        if ($this->readyToLoad) {
            if ($this->model == 'appointments') {
                return $this->user->appointments()->onlyTrashed()
                    ->where('user_id', '=', $this->user->id)
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
            }
            if ($this->model == 'pets') {
                return $this->user->pets()->onlyTrashed()->select('id', 'name', 'deleted_at')
                    ->where('user_id', '=', $this->user->id)
                    ->when(strlen($this->search) > 0, function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->paginate);
            }
        } else {
            return [];
        }
    }

    public function render()
    {
        return view('livewire.inline.dumpster', [
            'items' => $this->items
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('trash_destroy');

        $item = $this->user->{$this->model}()->onlyTrashed()->find($id);
        //Delete physically user image
        if ($item->profile_photo_path != null) {
            unlink('storage/' . $item->profile_photo_path);
            $item->profile_photo_path = null;
            $item->save();
        }
        $item->forceDelete();

        $this->dispatchBrowserEvent('deleted-dumpster', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Item permanently deleted.'
        ]);

        if ($this->model == 'pets') {
            $this->emit('refresh-pets');
        }

        if ($this->model == 'appointments') {
            $this->emit('refresh-appointments');
        }
    }

    public function destroyMultiple()
    {
        $this->authorize('trash_destroy');

        //Si no hay items seleccionados
        if (!$this->selected) {
            $this->dispatchBrowserEvent('destroy-error-dumpster', [
                'title'    => 'Not deleted',
                'subtitle' => 'Warning!',
                'class'    => 'bg-light',
                'icon'     => 'fas fa-exclamation-triangle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => '0 items selected'
            ]);
            return;
        }

        // Si hay items seleccionados
        if ($this->selected) {
            $deletedtems = $this->user->{$this->model}()->withTrashed()->whereIn('id', $this->selected)
                ->select('id')
                ->pluck('id')
                ->toArray();

            $this->user->{$this->model}()->withTrashed()->whereIn('id', $this->selected)->forceDelete();

            $this->dispatchBrowserEvent('deleted-dumpster', [
                'title'    => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class'    => 'bg-danger',
                'icon'     => 'fas fa-check-circle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => count($deletedtems). ' item permanently deleted.'
            ]);
        }

        $this->resetUI();

        if ($this->model == 'pets') {
            $this->emit('refresh-pets');
        }

        if ($this->model == 'appointments') {
            $this->emit('refresh-appointments');
        }
    }

    public function restore($id)
    {
        $this->authorize('trash_restore');

        $item = $this->user->{$this->model}()->onlyTrashed()->find($id);
        $item->restore();
        $this->pushDeleted($id);

        $this->dispatchBrowserEvent('restored-dumpster', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Item restored.'
         ]);


    }

    public function restoreMultiple()
    {
        $this->authorize('trash_restore');

        //Si no hay items seleccionados
        if (!$this->selected) {
            $this->dispatchBrowserEvent('restore-error-dumpster', [
                'title'    => 'Not deleted',
                'subtitle' => 'Warning!',
                'class'    => 'bg-light',
                'icon'     => 'fas fa-exclamation-triangle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => '0 items selected'
            ]);
            return;
        }

        // Si hay items seleccionados
        if ($this->selected) {
            //Agregando al array $deleted aquellos que items que se restaurarán
            $this->pushDeleted();

            $deletedItems = $this->user->{$this->model}()->onlyTrashed()->whereIn('id', $this->selected)
                ->select('id')
                ->pluck('id')
                ->toArray();

            $this->user->{$this->model}()->onlyTrashed()->whereIn('id', $this->selected)->restore();

            $this->dispatchBrowserEvent('restored-multiple-dumpster', [
                'title'    => 'Restored',
                'subtitle' => 'Succesfully!',
                'class'    => 'bg-success',
                'icon'     => 'fas fa-check-circle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => count($deletedItems). ' items restored.'
            ]);
        }

        $this->resetUI();

        if ($this->model == 'pets') {
            $this->emit('refresh-pets');
        }

        if ($this->model == 'appointments') {
            $this->emit('refresh-appointments');
        }
    }

    // Vuelve a eliminar los items que han sido restaurados
    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);

        $restoredItems = $this->user->{$this->model}()->whereIn('id', $this->deleted[$last])
            ->select('id')
            ->pluck('id')
            ->toArray();

        // Softdelete a los ids contenidos de la última posición del array (los últimos que fueron restaurados)
        $this->user->{$this->model}()->whereIn('id', $this->deleted[$last])
            ->delete();

        $this->dispatchBrowserEvent('restored-dumpster', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => count($restoredItems). ' items deleted.'
        ]);

        // Elimina el último elemento del array de arrays
        unset($this->deleted[$last]);
        $this->resetUI();
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
        $this->selected = [];
        $this->select_page = false;
        $this->search = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
