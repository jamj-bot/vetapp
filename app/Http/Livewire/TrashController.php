<?php

namespace App\Http\Livewire;

use App\Models\Parasiticide;
use App\Models\Pet;
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

    // Datatable atribbutes
    public $paginate = '50', $sort = 'deleted_at', $direction = 'desc', $readyToLoad = false, $search = '';

    // General attributes
    public $pageTitle;

    // Listeners
    protected $listeners = [
        'destroy'
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
     *  Funtion to reset pagination when a user writtes in search field
     *
    **/
    public function updatingSearch()
    {
        $this->resetPage();
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
        $this->pageTitle = 'Recycle bin';
    }

    public function render()
    {
        $this->authorize('trash_index');

        if ($this->readyToLoad) {

            if (strlen($this->search) > 0) {
                $users = User::onlyTrashed()
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->select('id', 'name', 'deleted_at', DB::raw("1 as model"))
                    ->get();

                $species = Species::onlyTrashed()
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->select('id', 'name', 'deleted_at', DB::raw("2 as model"))
                    ->get();

                $pets = Pet::onlyTrashed()
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->select('id', 'name', 'deleted_at', DB::raw("3 as model"))
                    ->get();

                $vaccines = Vaccine::onlyTrashed()
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->select('id', 'name', 'deleted_at', DB::raw("4 as model"))
                    ->get();

                /**
                 * Se unen las callecciones de distintos modelos.
                 * Para  paginar la Collection se debe agregar una función
                 * en AppServiceProvider dentro de "boot()".
                 **/
                $items = $users->concat($species)->concat($pets)->concat($vaccines)
                    ->sortByDesc([
                        [$this->sort, $this->direction]])
                    ->paginate($this->paginate);
            } else {

                $users = User::onlyTrashed()
                    ->select('id', 'name', 'deleted_at', DB::raw("1 as model"))
                    ->get();

                $species = Species::onlyTrashed()
                    ->select('id', 'name', 'deleted_at', DB::raw("2 as model"))
                    ->get();

                $pets = Pet::onlyTrashed()
                    ->select('id', 'name', 'deleted_at', DB::raw("3 as model"))
                    ->get();

                $vaccines = Vaccine::onlyTrashed()
                    ->select('id', 'name', 'deleted_at', DB::raw("4 as model"))
                    ->get();

                $parasiticides = Parasiticide::onlyTrashed()
                    ->select('id', 'name', 'deleted_at', DB::raw("5 as model"))
                    ->get();

                $items = $users->concat($species)->concat($pets)->concat($vaccines)->concat($parasiticides)
                    ->sortByDesc([[$this->sort, $this->direction]])
                    ->paginate($this->paginate);
            }

        }  else {
            $items = [];
        }

        return view('livewire.trash.component', compact('items'))
            ->extends('admin.layout.app')
            ->section('content');
    }


    public function restore($id = null, $model = null)
    {
        $this->authorize('trash_restore');

        if ($id != null) {
            // Busco el item de acuerdo al modelo al que pertenece : 1 = User, 2 = Species
            if ($model == 1) {
                $item = User::onlyTrashed()->find($id);
            } elseif ($model == 2) {
                $item = Species::onlyTrashed()->find($id);
            } elseif ($model == 3) {
                $item = Pet::onlyTrashed()->find($id);
            } elseif ($model == 4) {
                $item = Vaccine::onlyTrashed()->find($id);
            } elseif ($model == 5) {
                $item = Parasiticide::onlyTrashed()->find($id);
            }

            $item->restore();

            $this->dispatchBrowserEvent('restored', [
                'title' => 'Restored',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-success',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'This item has been restored succesfully. Now, you can find it again in users section.'
            ]);
        } else {
            $users = User::onlyTrashed()->restore();
            $species = Species::onlyTrashed()->restore();
            $pets = Pet::onlyTrashed()->restore();
            $vaccines = Vaccine::onlyTrashed()->restore();
            $parasiticides = Parasiticide::onlyTrashed()->restore();

            $this->dispatchBrowserEvent('restored', [
                'title' => 'Restored',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-success',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'All items has been restored succesfully. Now, you can find them again in users section.'
            ]);
        }
    }

    public function destroy($id = null, $model = null)
    {
        $this->authorize('trash_destroy');

        if ($id != null) {
            if ($model == 1) {
                $item = User::onlyTrashed()->find($id);
                //Delete physically image
                if ($item->profile_photo_path != null) {
                    unlink('storage/' . $item->profile_photo_path);
                    $item->profile_photo_path = null;
                    $item->save();
                }
            } elseif ($model == 2) {
                $item = Species::onlyTrashed()->find($id);
            } elseif ($model == 3) {
                $item = Pet::onlyTrashed()->find($id);
            } elseif ($model == 4) {
                $item = Vaccine::onlyTrashed()->find($id);
            }

            $item->forceDelete();

        } else {
            $users = User::onlyTrashed()->get();
            foreach ($users as $user) {
                // Delete image from folder
                if ($user->profile_photo_path != null) {
                    unlink('storage/' . $user->profile_photo_path);
                    $user->profile_photo_path = null;
                    $user->save();
                }

                // Delete 'image' from database
                $user->forceDelete();
            }

            $species = Species::onlyTrashed()->forceDelete();
            $pets = Pet::onlyTrashed()->forceDelete();
            $vaccine = Vaccine::onlyTrashed()->forceDelete();
            $parasiticides = Parasiticide::onlyTrashed()->forceDelete();
        }
    }
}
