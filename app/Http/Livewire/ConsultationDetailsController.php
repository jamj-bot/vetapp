<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Disease;
use App\Models\Image;
use App\Models\Medicine;
use App\Models\Pet;
use App\Models\Prescription;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConsultationDetailsController extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    // General attributes
    public $pageTitle, $modalTitle;


    public $pet_id, $consultation_id;

    // CRUD attributes
    public $selected_id,
        $age,
        $weight,
        $temperature,
        $oxygen_saturation_level,
        $capillary_refill_time = 'choose',
        $heart_rate,
        $pulse = 'choose',
        $respiratory_rate,
        $reproductive_status = 'choose',
        $consciousness = 'choose',
        $hydration = 'choose',
        $pain = 'choose',
        $body_condition = 'choose',
        $problem_statement,
        $types_of_diagnosis = [],
        $prognosis = 'choose',
        $color = '',
        $treatment_plan,
        $consult_status = 'choose',
        $disease ='';

    // Upload images
    public $images = [];

    // Upload tests
    public $tests = [];

    /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'age'                     => 'required|string|min:3|max:255',
            'weight'                  => 'required|numeric|numeric|between:0,9999.999|regex:/^\d+(\.\d{1,3})?$/',
            'temperature'             => 'required|numeric|between:0,99.99|regex:/^\d+(\.\d{1,2})?$/',
            'oxygen_saturation_level' => 'nullable|integer|between:0,100',
            'capillary_refill_time'   => 'required|in:"Less than 1 second","1-2 seconds","Longer than 2 seconds"',
            'heart_rate'              => 'required|integer|between:0,2000',
            'pulse'                   => 'required|in:"Strong and synchronous with each heart beat","Irregular","Bounding","Weak or absent"',
            'respiratory_rate'        => 'required|integer|between:0,200',
            'reproductive_status'     => 'required|in:"Pregnant","Lactating","Neither"',
            'consciousness'           => 'required|in:"Alert and responsive","Depressed or obtunded","Stupor","Comatose"',
            'hydration'               => 'required|in:"Normal","0-5%","6-7%","8-9%","+10%"',
            'pain'                    => 'required|in:"None","Vocalization","Changes in behavior","Physical changes"',
            'body_condition'          => 'required|in:"Very thin","Thin","Normal","Fat","Very fat"',
            'problem_statement'       => 'required|string|min:15|max:65000',
            'disease'                 => 'required|max:255',
            'types_of_diagnosis'      => 'required|max:255',
            'prognosis'               => 'required|in:"Pending","Good","Fair","Guarded","Grave","Poor"',
            'treatment_plan'          => 'nullable|string|min:3|max:2000',
            'consult_status'          => 'required|in:"In process", "Closed"',
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
     *  function para verificar si la página ya se cargó.
     *
    **/
    public function loadItems()
    {
        $this->readyToLoad = true;
    }

    public function mount($pet, $consultation)
    {
        $this->pageTitle = 'Consultations / '.str_pad($consultation, 5, "0", STR_PAD_LEFT);
        $this->modalTitle = 'Consultation';

        $this->pet_id = $pet;
        $this->consultation_id = $consultation;

        // Cargar en formulario el contenido del campo problem_statement
        $this->problem_statement = Consultation::findOrFail($consultation)->problem_statement;

    }


    public function getConsultationProperty()
    {
        return Consultation::findOrFail($this->consultation_id);
    }

    public function getPetProperty()
    {
        return Pet::findOrFail($this->pet_id);
    }

    public function getPrescriptionsProperty()
    {
        return Prescription::where('consultation_id', $this->consultation_id)->get();
    }

    public function render()
    {
        $this->authorize('consultations_show');

        //ERROR 404 cuando la consulta no pertenece a la mascota
        if ($this->consultation->pet->id != $this->pet->id) {
            abort(404);
        }

        return view('livewire.consultation.details.component', [
                'consultation'  => $this->consultation,
                'pet'           => $this->pet,
                'prescriptions' => $this->Prescriptions
            ])->extends('admin.layout.app')
            ->section('content');
    }

    public function edit(Consultation $consultation)
    {
        $this->selected_id = $consultation->id;
        $this->age = $consultation->age;
        $this->weight = $consultation->weight;
        $this->temperature = $consultation->temperature;
        $this->oxygen_saturation_level = $consultation->oxygen_saturation_level;
        $this->capillary_refill_time = $consultation->capillary_refill_time;
        $this->heart_rate = $consultation->heart_rate;
        $this->pulse = $consultation->pulse;
        $this->respiratory_rate = $consultation->respiratory_rate;
        $this->reproductive_status = $consultation->reproductive_status;
        $this->consciousness = $consultation->consciousness;
        $this->hydration = $consultation->hydration;
        $this->pain = $consultation->pain;
        $this->body_condition = $consultation->body_condition;
        $this->problem_statement = $consultation->problem_statement;
        $this->types_of_diagnosis = explode(", ", $consultation->types_of_diagnosis);
        $this->prognosis = $consultation->prognosis;
        $this->treatment_plan = $consultation->treatment_plan;
        $this->consult_status = $consultation->consult_status;
        $this->disease = Str::ucfirst($consultation->diseases->implode('name', '; '));

        $this->emit('show-modal', 'show-modal');
    }

    /*
     * El parámetro que se recibe el el valor del campo oculto id ="textareaProblemStatement"
     *
     */
    public function update($problem_statement)
    {

        $this->authorize('consultations_update');

        $this->problem_statement = $problem_statement; // <- se asigna el parámetro a la propiedad $problem_statement

        $this->types_of_diagnosis = implode(", ", $this->types_of_diagnosis);

        // Asigno un color a la cansulta
        switch ($this->prognosis) {
            case 'Good':
                $this->color = 'text-success';
                break;

            case 'Fair':
                $this->color = 'text-olive';
                break;

            case 'Guarded':
                $this->color = 'text-warning';
                break;

            case 'Grave':
                $this->color = 'text-orange';
                break;

            case 'Poor':
                $this->color = 'text-danger';
                break;

            case 'Pending':
                $this->color = 'text-muted';
                break;
        }

        $validatedData = $this->validate();
        $consultation = consultation::findOrFail($this->selected_id);
        $consultation->color = $this->color;
        $consultation->update($validatedData);

        // String disease, se convierte en
        foreach(explode("; ", $this->disease) as $disease)
        {
            $diseases[] = Disease::firstOrCreate(['name' => Str::of($disease)->trim()])->id;
        }
        $consultation->diseases()->sync($diseases);

        $this->emit('hide-modal', 'hide-modal');

        $this->dispatchBrowserEvent('updated', [
            'title' => 'Updated',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Consultation updated.'
        ]);
    }

    public function delete(Consultation $consultation)
    {
        $consultation->delete();
        redirect()->route('admin.pets.consultations', ['pet' => $this->pet]);
    }

    public function previusConsultation()
    {

        $consultation = $this->pet->consultations()
            ->orderBy('updated_at', 'desc')
            ->where('updated_at', '<', $this->consultation->updated_at)
            ->first();

        if ($consultation) {
            redirect()->route('admin.pets.consultations.show', ['pet' => $this->pet, 'consultation' => $consultation]);
        } else {
            session()->flash('message', 'First consultation stored.');
        }
    }

    public function nextConsultation()
    {

        $consultation = $this->pet->consultations()
            ->orderBy('updated_at', 'asc')
            ->where('updated_at', '>', $this->consultation->updated_at)
            ->first();

        if ($consultation) {
            redirect()->route('admin.pets.consultations.show', ['pet' => $this->pet, 'consultation' => $consultation]);
        } else {
            session()->flash('message', 'Last consultation stored.');
        }
    }

    public function updatedImages()
    {
        $this->validate([
            'images.*' => 'required|image|mimes:png,jpeg,jpg,gif|max:3072' //2 MB max
        ]);
    }

    public function updatedTests()
    {
        $this->validate([
            'tests.*' => 'required|mimes:pdf|max:3072' //2 MB max mimes:xlsx, csv, xls
        ]);
    }

    public function saveImages()
    {
        $this->authorize('consultations_save_files');

        $consultation = Consultation::findOrFail($this->consultation_id);

        $this->validate([
            'images.*' => 'required|image|mimes:png,jpeg,jpg,gif|max:3072' //2 MB max
        ]);

        foreach ($this->images as $image) {
            $originalName = Str::of($image->getClientOriginalName())->substr(0, -4); //elimina ultimos 4 caracteres (p. ej. .png)

            $newName = Carbon::now()->format('d-M-Y') . ' - ' .
                Str::slug($originalName, '-'); // concatena fecha + nombre file + nombre mascota

            $name = Str::upper($newName);

            $url = uniqid() . '.' . $image->extension();

            $image->storeAs('public/medical-imaging', $url);

            $consultation->images()->create([
                'url' => 'medical-imaging/' . $url,
                'name' => $name
            ]);
        }

        $this->images = [];

        $this->emit('clear-input-field', 'clear-input-field');

        $this->dispatchBrowserEvent('uploaded', [
            'title' => 'Uploaded',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Image uploaded.'
        ]);
    }

    public function downloadImage(Image $image)
    {
        $this->authorize('consultations_download_files');

        return Storage::download('public/' . $image->url, $image->name);
    }

    public function deleteImage(Image $image)
    {
        $this->authorize('consultations_delete_files');

        $imageTmp = $image->url;

        $image->delete();

        Storage::delete(['public/'. $imageTmp]);

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Image deleted.'
        ]);
    }

    public function saveTests()
    {
        $consultation = Consultation::findOrFail($this->consultation_id);

        $this->validate([
            'tests.*' => 'required|mimes:pdf|max:3072'
        ]);

        foreach ($this->tests as $test) {

            $originalName = Str::of($test->getClientOriginalName())->substr(0, -4); //elimina ultimos 4 caracteres (p. ej. .png)

            $newName = Carbon::now()->format('d-M-Y') . ' - ' .
                Str::slug($originalName, '-'); // concatena fecha + nombre file + nombre mascota

            $name = Str::upper($newName);
            $url = uniqid() . '.' . $test->extension();

            $test->storeAs('public/tests', $url);

            $consultation->tests()->create([
                'url' => 'tests/' . $url,
                'name' => $name,
                'extension' => $test->extension()
            ]);
        }

        $this->tests = [];

        $this->emit('clear-input-field', 'clear-input-field');

        $this->dispatchBrowserEvent('uploaded', [
            'title' => 'Uploaded',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Lab test uploaded.'
        ]);
    }

    public function downloadTest(Test $test)
    {
        return Storage::download('public/' . $test->url, $test->name);
    }

    public function deleteTest(Test $test)
    {
        $testTmp = $test->url;

        $test->delete();

        Storage::delete(['public/'. $testTmp]);

        $this->dispatchBrowserEvent('deleted', [
            'title' => 'Deleted',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'Lab test deleted.'
        ]);
    }

    public function resetUI()
    {
        $this->selected_id = null;
        $this->age = '';
        $this->weight = null;
        $this->temperature = null;
        $this->oxygen_saturation_level = null;
        $this->capillary_refill_time = 'choose';
        $this->heart_rate = null;
        $this->pulse = 'choose';
        $this->respiratory_rate = null;
        $this->reproductive_status = 'choose';
        $this->consciousness = 'choose';
        $this->hydration = 'choose';
        $this->pain = 'choose';
        $this->body_condition = 'choose';
        $this->problem_statement = '';
        $this->types_of_diagnosis = [];
        $this->prognosis = 'choose';
        $this->color = '';
        $this->treatment_plan = '';
        $this->consult_status = 'choose';
        $this->disease = '';

        // $this->selected = [];
        // $this->select_page = false;

        $this->resetValidation();
        // $this->emit('reset-ckeditor', 'reset-ckeditor');
    }
}
