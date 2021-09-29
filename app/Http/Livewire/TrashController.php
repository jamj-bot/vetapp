<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;


class TrashController extends Component
{

    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Atribbutes for Recycle bin
    public $sort = 'deleted_at', $readyToLoad = false;

    // General ttributes for component
    public $pageTitle;

    // Listeners
    protected $listeners = [
        'destroy'
    ];

    /**
     *  Funtion to reset pagination when a filter changes
    **/
    public function resetPagination()
    {
        $this->resetPage();
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
            $users = User::onlyTrashed()->orderBy($this->sort, 'desc')->simplePaginate(12);
        }  else {
            $users = [];
        }

        return view('livewire.trash.component', compact('users'))
            ->extends('admin.layout.app')
            ->section('content');
    }


    public function restore($id = null)
    {
        $this->authorize('trash_restore');

        if ($id != null) {
            $user = User::onlyTrashed()->find($id);
            $user->restore();

            $this->dispatchBrowserEvent('restored', [
                'title' => 'Restored',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-success',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'This user has been restored succesfully. Now, you can find it again in users section.'
            ]);
        } else {
            $users = User::onlyTrashed()->restore();

            $this->dispatchBrowserEvent('restored', [
                'title' => 'Restored',
                'subtitle' => 'Succesfully!',
                'class' => 'bg-success',
                'icon' => 'fas fa-check-circle fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'All users has been restored succesfully. Now, you can find them again in users section.'
            ]);
        }



    }

    public function destroy($id = null)
    {
        $this->authorize('trash_destroy');

        if ($id != null) {
            $user = User::onlyTrashed()->find($id);

            //Delete physical image
            if ($user->profile_photo_path != null) {
                unlink('storage/' . $user->profile_photo_path);
                $user->profile_photo_path = null;
                $user->save();
            }

            $user->forceDelete();
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
        }
    }
}
