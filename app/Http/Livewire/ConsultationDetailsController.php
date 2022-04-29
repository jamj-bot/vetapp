<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Image;
use App\Models\Pet;
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

    public $pageTitle, $modalTitle;
    public $pet, $consultation_id, $current_consultation, $selected_consultation_id = null, $show = null;

    // Upload images
    public $images = [];

    // Upload tests
    public $tests = [];

    // CRUD attributes
    public $selected_id,
        $age,
        $weight,
        $temperature,
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
        $diagnosis,
        $prognosis = 'Pending',
        $treatment_plan,
        $consult_status = 'choose';

    /**
     *  Function that returns the validation rules
     *
    **/
    protected function rules()
    {
        return [
            'age'                   => 'required|string|min:3|max:255',
            'weight'                => 'required|numeric|numeric|between:0,9999.999|regex:/^\d+(\.\d{1,3})?$/',
            'temperature'           => 'required|numeric|between:0,99.99|regex:/^\d+(\.\d{1,2})?$/',
            'capillary_refill_time' => 'required|in:"Less than 1 second","1-2 seconds","Longer than 2 seconds"',
            'heart_rate'            => 'required|integer|between:0,2000',
            'pulse'                 => 'required|in:"Strong and synchronous with each heart beat","Irregular","Bounding","Weak or absent"',
            'respiratory_rate'      => 'required|integer|between:0,200',
            'reproductive_status'   => 'required|in:"Pregnant","Lactating","Neither"',
            'consciousness'         => 'required|in:"Alert and responsive","Depressed or obtunded","Stupor","Comatose"',
            'hydration'             => 'required|in:"Normal","0-5%","6-7%","8-9%","+10%"',
            'pain'                  => 'required|in:"None","Vocalization","Changes in behavior","Physical changes"',
            'body_condition'        => 'required|in:"Too thin","Ideal","Too heavy"',
            'problem_statement'     => 'required|string|min:15|max:65000',
            'diagnosis'             => 'nullable|string|min:3|max:500',
            'prognosis'             => 'required|in:"Pending","Good","Fair","Guarded","Grave","Poor"',
            'treatment_plan'        => 'nullable|string|min:3|max:2000',
            'consult_status'        => 'required|in:"Lab tests pending", "Radiology tests pending", "Closed"',
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
        $this->pageTitle = 'Consultation';
        $this->modalTitle = 'Consultation';

        $this->pet = Pet::findOrFail($pet);
        $this->consultation_id = $consultation;

        // Cargar en formulario el contenido del campo problem_statement
        $this->problem_statement = Consultation::findOrFail($consultation)->problem_statement;
    }

    public function render()
    {
        $this->authorize('consultations_show');

        if ($this->selected_consultation_id == null) {
            $consultation = Consultation::findOrFail($this->consultation_id);// recupero consulta con el id que se envió a través de la url
            $this->current_consultation = $consultation; // seasignada como consulta recuperada actualmente

        } elseif ($this->selected_consultation_id != null) {
            if ($this->show != null) {
                if ($this->show == 'next') {
                    $consultation = $this->pet->consultations()
                        ->orderBy('updated_at', 'asc')
                        ->where('updated_at', '>', $this->current_consultation->updated_at)
                        ->first();

                    if ($consultation == null) {
                        $consultation = $this->pet->consultations()
                            ->orderBy('updated_at', 'asc')
                            ->first();
                    }

                    $this->current_consultation = $consultation;
                } elseif ($this->show == 'previous') {
                    $consultation = $this->pet->consultations()
                        ->orderBy('updated_at', 'desc')
                        ->where('updated_at', '<', $this->current_consultation->updated_at)
                        ->first();
                    if ($consultation == null) {
                        if ($consultation == null) {
                            $consultation = $this->pet->consultations()
                                ->orderBy('updated_at', 'desc')
                                ->first();
                        }
                    }

                    $this->current_consultation = $consultation; // retrieved consultation es la consulta recuperada actualmente
                }
            }

        }

        // ERROR 4040 cuando la consulta no pertenece a la mascota
        if ($consultation->pet->id != $this->pet->id) {
            abort(404);
        }

        switch ($consultation->prognosis) {
            case 'Good':
                $consultation->color = 'text-success';
                break;
            case 'Fair':
                $consultation->color = 'text-olive';
                break;

            case 'Guarded':
                $consultation->color = 'text-warning';
                break;

            case 'Grave':
                $consultation->color = 'text-orange';
                break;

            case 'Poor':
                $consultation->color = 'text-danger';
                break;

            default:
                $consultation->color = 'text-muted';
                break;
        }

        return view('livewire.consultation.details.component', compact('consultation'))
            ->extends('admin.layout.app')
            ->section('content');
    }

    public function edit(Consultation $consultation)
    {
        $this->selected_id = $consultation->id;
        $this->age = $consultation->age;
        $this->weight = $consultation->weight;
        $this->temperature = $consultation->temperature;
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
        $this->diagnosis = $consultation->diagnosis;
        $this->prognosis = $consultation->prognosis;
        $this->treatment_plan = $consultation->treatment_plan;
        $this->consult_status = $consultation->consult_status;

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

        $validatedData = $this->validate();

        $consultation = consultation::findOrFail($this->selected_id);

        $consultation->update($validatedData);

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

    public function previusConsultation($id)
    {
        $this->selected_consultation_id = $id;
        $this->show = 'previous';
    }

    public function nextConsultation($id)
    {
        $this->selected_consultation_id = $id;
        $this->show = 'next';
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

            $newName = Carbon::now()->format('d-M-Y') . ' - ' . Str::of($originalName)->replaceMatches('/[^A-Za-z0-9]++/', ' '); // concatena fecha + nombre file

            $name = Str::of($newName)->title();
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
                Str::of($originalName)->replaceMatches('/[^A-Za-z0-9]++/', ' '); // concatena fecha + nombre file + nombre mascota

            $name = Str::of($newName)->title();
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
        $this->selected_id = '';
        $this->age = '';
        $this->weight = null;
        $this->temperature = null;
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
        $this->diagnosis = '';
        $this->prognosis = 'Pending';
        $this->treatment_plan = '';
        $this->consult_status = 'choose';

        //$this->emit('reset-ckeditor', 'reset-ckeditor');
    }
}
