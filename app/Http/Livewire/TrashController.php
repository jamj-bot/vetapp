<?php

namespace App\Http\Livewire;

use App\Models\Parasiticide;
use App\Models\Species;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class TrashController extends Component
{

    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Datatable attributes
    public $paginate = '50',
        $sort        = 'deleted_at',
        $direction   = 'desc',
        $search      = '',
        $readyToLoad = false,
        $model       = 'App\Models\User',
        $selected    = [],
        $deleted     = [],
        $select_page = false;

    // General attributes
    public $pageTitle, $modalTitle;

    // Listeners
    protected $listeners = [
        'destroy',
        'destroyMultiple'
    ];

    /**
     *  Query string than  urls with datatable filters
     *
     **/
    protected $queryString = [
        'search'    => ['except' => ''],
        'paginate'  => ['except' => '50'],
        'sort'      => ['except' => 'deleted_at'],
        'direction' => ['except' => 'desc']
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
        if ($this->readyToLoad) {
            return $this->model::onlyTrashed()
                ->where('name', 'like', '%' . $this->search . '%')
                ->select('id', 'name', 'deleted_at', DB::raw("'$this->model' as model"))
                ->when(strlen($this->search) > 0, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->paginate);
        } else {
            return [];
        }

    }

    public function render()
    {
        $this->authorize('trash_index');

        return view('livewire.trash.component', ['items' => $this->items])
            ->extends('admin.layout.app')
            ->section('content');
    }


    public function destroy($id)
    {
        $this->authorize('trash_destroy');

        $item = $this->model::onlyTrashed()->find($id);
        //Delete physically user image
        if ($item->profile_photo_path != null) {
            unlink('storage/' . $item->profile_photo_path);
            $item->profile_photo_path = null;
            $item->save();
        }
        $item->forceDelete();

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Item deleted: ' . $item->name
        ]);
    }

    public function destroyMultiple()
    {
        $this->authorize('trash_destroy');

        //Si no hay items seleccionados
        if (!$this->selected) {
            $this->dispatchBrowserEvent('destroy-error', [
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
            $deletedtems = $this->model::withTrashed()->whereIn('id', $this->selected)
                ->select('name')
                ->pluck('name')
                ->toArray();

            $this->model::withTrashed()->whereIn('id', $this->selected)->forceDelete();

            $this->dispatchBrowserEvent('deleted', [
                'title'    => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class'    => 'bg-danger',
                'icon'     => 'fas fa-check-circle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => count($deletedtems). ' items moved to Recycle bin: ' . implode(", ", $deletedtems)
            ]);
        }

        $this->resetUI();
    }

    public function restore($id)
    {
        $this->authorize('trash_restore');

        $item = $this->model::onlyTrashed()->find($id);
        $item->restore();
        $this->pushDeleted($id);

        $this->dispatchBrowserEvent('restored', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Item restored: ' . $item->name
         ]);
    }

    public function restoreMultiple()
    {
        $this->authorize('trash_restore');

        //Si no hay items seleccionados
        if (!$this->selected) {
            $this->dispatchBrowserEvent('restore-error', [
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

            $this->model::whereIn('id', $this->selected)->restore();

            $deletedItems = $this->model::whereIn('id', $this->selected)
                ->select('name')
                ->pluck('name')
                ->toArray();

            $this->dispatchBrowserEvent('restored-multiple', [
                'title'    => 'Deleted',
                'subtitle' => 'Succesfully!',
                'class'    => 'bg-success',
                'icon'     => 'fas fa-check-circle fa-lg',
                'image'    => auth()->user()->profile_photo_url,
                'body'     => count($deletedItems). ' items restored: ' . implode(", ", $deletedItems)
            ]);
        }

        $this->resetUI();
    }

    // Vuelve a eliminar los items que han sido restaurados
    public function undoMultiple()
    {
        // última posición del array $deleted
        $last = array_key_last($this->deleted);

        $restoredItems = $this->model::whereIn('id', $this->deleted[$last])
            ->select('name')
            ->pluck('name')
            ->toArray();

        // Softdelete a los ids contenidos de la última posición del array (los últimos que fueron restaurados)
        $this->model::whereIn('id', $this->deleted[$last])
            ->delete();

        $this->dispatchBrowserEvent('restored', [
            'title' => 'Restored',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => count($restoredItems). ' items deleted: ' . implode(", ", $restoredItems)
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
