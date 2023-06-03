<?php

namespace App\Http\Livewire\Inline;

use Livewire\Component;

class RecentlyAddedImages extends Component
{

    // Receiving parameter
    public $pet;
    public $load = 4;
    public $testsQuantity;

    public function mount()
    {
        $this->testsQuantity = count($this->pet->images()->get());
    }

    public function render()
    {
        $images = $this->pet->images()->latest()->paginate($this->load);

        return view('livewire.inline.recently-added-images', compact('images'));
    }

    public function loadMore()
    {
        if ($this->load < $this->testsQuantity ) {
            $this->load = $this->load + 4;
        }
    }
}

