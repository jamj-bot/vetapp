<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use App\Models\Medicine;
use App\Models\Pet;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    public $selectedMedicines; // For select input

    public
        $date,
        $expiry,
        $order,
        $repeat = 'choose',
        $number_of_repeats,
        $interval_between_repeats = '',
        $further_information;

    public $search = '';


     /**
     *  Function that returns the validation rules
     *
    **/
     protected function rules() {
        return [
            'date'                     => ['required', 'date', 'after:yesterday', 'before:tomorrow'],
            'expiry'                   => ['nullable', 'date', 'after_or_equal:date'],
            'repeat'                   => ['required', 'boolean'],
            'number_of_repeats'        => [
                                            'required_if:repeat,1',
                                            'min:1', 'max:4',
                                            'numeric',
                                             Rule::when($this->repeat == 0, ['nullable']),
                                          ],
            'interval_between_repeats' => [
                                            'required_if:repeat,true',
                                            'string',
                                            Rule::when($this->repeat == false, ['nullable']),
                                            'in:1 week,2 weeks,3 weeks,1 month,2 months,3 months',
                                          ],
            'further_information'      => ['nullable', 'string', 'min:3', 'max:2048'],

            // Reglas de validación para los medicamentos recetados
            'prescribedMedicines.*.medicine_id'           => ['required', 'numeric', 'exists:medicines,id', 'distinct'],
            'prescribedMedicines.*.quantity'              => ['required', 'string', 'min:1', 'max:255'],
            'prescribedMedicines.*.indications_for_owner' => ['required', 'string', 'min:3', 'max:255'],
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
        $this->selectedMedicines = collect();

        $this->date = $this->date = now()->toDateString();

        $this->pet = Pet::findOrFail($pet);
        $this->consultation = Consultation::findOrFail($consultation);
        $this->pageTitle = 'Prescription';

        $this->prescribedMedicines = [
            [
                'medicine_id'           => '',
                'name'                  => '',
                'quantity'              => '',
                'indications_for_owner' => ''
            ]
        ];
    }

    public function getMedicinesProperty()
    {
        $stopWords = ['de', 'para', 'of', 'the']; // Defino palabras que deseo eliminar de la búsqueda
        $keywords = preg_split('/[\s,]+/', $this->search); // Defino las palabras clave en un array.
        $keywords = array_filter($keywords); // Elimina palabras clave que sean una cadena vacía.
        $keywords = array_diff($keywords, $stopWords); // Elimino las palabras que deseo eliminar de la busqueda

        return Medicine::when(count($keywords) > 0, function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%'. $keyword .'%')
                        ->orWhere('therapeutic_properties', 'like', '%'. $keyword .'%');
                });
            }
        })
        ->when(strlen($this->search) == 0, function ($query) {
            $query->take(10);
        })->orderBy('name')->get();
    }

    public function getPrescriptionsProperty()
    {
        return Prescription::where('consultation_id', $this->consultation->id)->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        $this->authorize('prescriptions_index');

        // Si el pet_id de la consultation no es igual a id de la pet a la que se está prescribiendo: ERROR 404
        if ($this->consultation->pet->id != $this->pet->id) {
            abort(404);
        }

        return view('livewire.prescription.component', [
                'prescriptions' => $this->prescriptions,
                'medicines' => $this->medicines
            ])
            ->extends('admin.layout.app')
            ->section('content');

    }

    public function setMedicine($index)
    {
        // Agregando la medicine a la coleccion $this->selectedMedicines
        $medicineIds = [];
        foreach ($this->prescribedMedicines as $prescribedMedicine) {
            $medicineIds[] = $prescribedMedicine['medicine_id'];
        }
        $this->selectedMedicines = Medicine::whereIn('id', $medicineIds)->get();
    }

    public function addMedicine()
    {
        $this->prescribedMedicines[] =
            [
                'medicine_id'           => '',
                'name'                  => '',
                'quantity'              => '',
                'indications_for_owner' => ''
            ];
    }

    public function removeMedicine($index)
    {
        // Eliminando elemento de la coleccion $this->selectedMedicines por el id de elemento.
        $medicineIdToRemove = $this->prescribedMedicines[$index]['medicine_id'];
        $this->selectedMedicines = $this->selectedMedicines->reject(function ($medicine) use
            ($medicineIdToRemove) {
                return $medicine->id == $medicineIdToRemove;
            });


        // Eliminando del array $this->prescibedMedicines por el indice del array.
        if (count($this->prescribedMedicines) > 1) {
            unset($this->prescribedMedicines[$index]);
            $this->prescribedMedicines = array_values($this->prescribedMedicines);
            $this->resetValidation();
        } else {
            $this->prescribedMedicines = [
                [
                    'medicine_id'           => '',
                    'name'                  => '',
                    'quantity'              => '',
                    'indications_for_owner' => ''
                ]
            ];
        }
    }

    // [
    //     'email.required' => 'The :attribute cannot be empty.',
    //     'email.email' => 'The :attribute format is not valid.',
    // ],
    // ['email' => 'Email Address']

    public function store()
    {
        $this->authorize('prescriptions_store');

        $validatedData = $this->validate();

        $prescription = $this->consultation->prescriptions()->create($validatedData);

        $prescription->instructions()->createMany(
            $validatedData['prescribedMedicines']
        );

        $this->resetUI();

        $this->dispatchBrowserEvent('stored', [
            'title' => 'Created',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-primary',
            'icon' => 'fas fa-plus fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'The prescription [order: ' . $prescription->order . '] has been stored.'
        ]);
    }


    public function void($id)
    {
        $this->authorize('prescriptions_void');

        $prescription = Prescription::findOrFail($id);
        $prescription->update([
            'voided' => 1
        ]);
        $prescription->save();

        $this->dispatchBrowserEvent('voided', [
            'title' => 'Voided',
            'subtitle' => 'Succesfully!',
            'class' => 'bg-danger',
            'icon' => 'fas fa-check-circle fa-lg',
            'image' => auth()->user()->profile_photo_url,
            'body' => 'The prescription [order: ' . $prescription->order . '] has been voided.'
        ]);
    }


    public function resetUI()
    {
        $this->date = $this->date = now()->toDateString();
        $this->expiry = '';
        $this->order = '';
        $this->repeat = 'choose';
        $this->number_of_repeats = null;
        $this->interval_between_repeats = '';
        $this->further_information = '';
        $this->search = '';
        $this->prescribedMedicines = [
            [
                'medicine_id'           => '',
                'name'                  => '',
                'quantity'              => '',
                'indications_for_owner' => ''
            ]
        ];
        $this->selectedMedicines = collect();
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