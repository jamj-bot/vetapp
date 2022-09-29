<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Medicine;
use App\Models\Pet;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PrescriptionController extends Component
{
    use AuthorizesRequests;

     // General attributes
    public $pet, $consultation;
    public $pageTitle, $modalTitle;

    public $prescribedMedicines = [];
    public $allMedicines = [];

    public $date, $expiry, $order, $repeat = 'choose', $number_of_repeats, $interval_between_repeats, $further_information;
    public $search = '';


     /**
     *  Function that returns the validation rules
     *
    **/
     protected function rules() {
        return [
            'date'                     => ['required', 'date', 'after:yesterday', 'before:tomorrow'],
            'expiry'                   => ['nullable', 'date', 'after_or_equal:date'],
            //'order'                  => "required|numeric|digits:10|unique:prescriptions,order,{$this->selected_id}",
            'order'                    => ['required', 'numeric', 'digits:10', 'unique:prescriptions,order'],
            'repeat'                   => ['required', 'boolean'],
            'number_of_repeats'        => [
                                            'required_if:repeat,1',
                                            'min:1', 'max:1000',
                                            'numeric',
                                             Rule::when($this->repeat == 0, ['nullable']),
                                          ],
            'interval_between_repeats' => [
                                            'required_if:repeat,1',
                                            'min:4', 'max:255',
                                            'string',
                                             Rule::when($this->repeat == 0, ['nullable']),
                                          ],
            'further_information'      => ['nullable', 'string', 'min:3', 'max:2048']
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

    public function mount($pet, $consultation)
    {
        $this->pet = Pet::findOrFail($pet);
        $this->consultation = Consultation::findOrFail($consultation);
        $this->pageTitle = 'Prescription';

        $this->allMedicines = Medicine::where('name', 'like', '%'. $this->search .'%')->orderBy('name')->get();
        $this->prescribedMedicines = [
            ['medicine_id' => '', 'quantity' => 1, 'indications_for_owner' => '']
        ];
    }

    public function getPrescriptionsProperty()
    {
        return Prescription::where('consultation_id', $this->consultation->id)->get();
    }

    public function render()
    {
        return view('livewire.prescription.component', ['prescriptions' => $this->prescriptions])
            ->extends('admin.layout.app')
            ->section('content');

    }

    public function addMedicine()
    {
        $this->prescribedMedicines[] = ['medicine_id' => '', 'quantity' => 1, 'indications_for_owner' => ''];
    }

    public function removeMedicine($index)
    {
        if (count($this->prescribedMedicines) > 1) {
            unset($this->prescribedMedicines[$index]);
            $this->prescribedMedicines = array_values($this->prescribedMedicines);
            $this->resetValidation();
        } else {
            $this->dispatchBrowserEvent('not-deleted', [
                'title' => 'Not deleted',
                'subtitle' => 'Warning!',
                'class' => 'bg-warning',
                'icon' => 'fas fa-warning fa-lg',
                'image' => auth()->user()->profile_photo_url,
                'body' => 'User information has been updated correctly.'
            ]);
        }
    }

    public function store()
    {
        $validatedData = $this->validate();

        $prescription = $this->consultation->prescriptions()->create($validatedData);

        $validatedData2 = $this->validate(
            [
                'prescribedMedicines.*.medicine_id'           => 'required|numeric|exists:medicines,id|distinct',
                'prescribedMedicines.*.quantity'              => 'required|numeric|min:1|max:2000',
                'prescribedMedicines.*.indications_for_owner' => 'required|string|min:3|max:580',
            ],
            // [
            //     'email.required' => 'The :attribute cannot be empty.',
            //     'email.email' => 'The :attribute format is not valid.',
            // ],
            // ['email' => 'Email Address']
        );

        $prescription->instructions()->createMany(
            $validatedData2['prescribedMedicines']
        );

        $this->resetUI();
    }


    public function resetUI()
    {
        $this->date = '';
        $this->expiry = '';
        $this->order = '';
        $this->repeat = 'choose';
        $this->number_of_repeats = null;
        $this->interval_between_repeats = '';
        $this->further_information = '';
        $this->prescribedMedicines = [
            ['medicine_id' => '', 'quantity' => 1, 'indications_for_owner' => '']
        ];
    }
}



        // DB::beginTransaction();

        // try {

        //     $sale = Sale::create([
        //         'total' => $this->total,
        //         'items' => $this->itemsQuantity,
        //         'cash' => $this->cash,
        //         'change' => $this->change,
        //         'user_id' => Auth::user()->id
        //     ]);

        //     if ($sale) {
        //         $items = Cart::getContent();
        //         foreach ($items as $item) {
        //             SaleDetail::create([
        //                 'price' => $item->price,
        //                 'quantity' => $item->quantity,
        //                 'product_id' => $item->id,
        //                 'sale_id' => $sale->id,
        //             ]);

        //             $product = Product::find($item->id);
        //             $product->stock = $product->stock - $item->quantity;
        //             $product->save();
        //         }
        //     }

        //     DB::commit();
        //     Cart::clear();
        //     $this->cash = 0;
        //     $this->change = 0;
        //     $this->total = Cart::getTotal();
        //     $this->itemsQuantity = Cart::getTotalQuantity();

        //     $this->emit('sale-ok', 'Venta realizada con éxito');
        //     $this->emit('print-ticket', $sale->id);


        // } catch (Exception $e) {
        //     DB::rollback();
        //     $this->emit('sale-error', $e->getMessage());
        // }