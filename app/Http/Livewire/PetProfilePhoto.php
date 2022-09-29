<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class PetProfilePhoto extends Component
{
    use WithFileUploads;

    public $pet;
    public $photo;


    /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024']
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

    public function render()
    {
        return view('livewire.pet-profile-photo');
    }

    public function updatePhoto()
    {
        $validatedData = $this->validate();

        if($this->photo) {
            $imgTmp = $this->pet->image;

            $url = uniqid() . '.' . $this->photo->extension();
            $this->photo->storeAs('public/pet-profile-photos', $url);
            $this->pet->image = $url;
            $this->pet->save();


            if ($imgTmp != null) {
                if (file_exists('storage/pet-profile-photos/' . $imgTmp)) {
                    unlink('storage/pet-profile-photos/' . $imgTmp);
                }
            }

            $this->photo = null;
            session()->flash('message', 'Saved.');
        }
    }

    public function removePhoto()
    {
        if ($this->pet->image != null) {
            if (file_exists('storage/pet-profile-photos/' . $this->pet->image )) {
                unlink('storage/pet-profile-photos/' . $this->pet->image );
            }

            $this->pet->image = null;
            $this->pet->save();

            return redirect(request()->header('Referer'));
        }
    }
}
