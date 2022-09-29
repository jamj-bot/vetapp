<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RecentlyAddedTests extends Component
{
    // Receiving parameter
    public $pet;
    public $load = 4;
    public $testsQuantity;


    public function mount()
    {
        $this->testsQuantity = count($this->pet->tests()->get());
    }

    public function render()
    {
        $tests = $this->pet->tests()->latest()->paginate($this->load);

        return view('livewire.recently-added-tests', compact('tests'));
    }

    public function loadMore()
    {
        if ($this->load < $this->testsQuantity ) {
            $this->load = $this->load + 4;
        }
    }
}
