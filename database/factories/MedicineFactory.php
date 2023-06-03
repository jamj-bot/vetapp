<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Medicine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(
                [
                    'Abamectin',
                    'Acetato de melengestrol',
                    'Acetato de trembolona',
                    'Albendazol',
                    'Amoxicillina',
                    'Ampicilina',
                    'Avilamicina',
                    'Azaperona',
                    'Bencilpenicilina/Bencilpenicilina procaínica',
                    'Benzoato de emamectina',
                    'Ciflutrín',
                    'Cihalotrin',
                    'Cipermetrina y alpfa-cypermetrina',
                    'Clenbuterol',
                    'Cloranfenicol',
                    'Clorpromazina',
                    'Derquantel',
                    'Dexametasona',
                    'Diciclanil',
                    'Diclazuril',
                    'Diflubenzurón',
                    'Espectinomicina',
                    'Espiramicina',
                    'Estilbenos',
                    'Flubendazol',
                    'Flumequina',
                    'Flumetrina',
                    'Foxim',
                    'Halquinol',
                    'Isometamidio',
                    'Ivermectina',
                    'Monepantel',
                    'Moxidectin',
                    'Neomicina',
                    'Nicarbacina',
                    'Nitrofural',
                    'Pirlimycina',
                    'Progesterona',
                    'Sarafloxacin',
                    'Somatotropina porcina',
                    'Sulfadimidina',
                    'Tiabendazol',
                    'Tilmicosin',
                    'Tilosina',
                    'Verde malaquita',
                    'Violet de genciana',
                    'Zeranol'
                ]),
            'strength' => $this->faker->randomElement(
                [
                    '500 mg',
                    '10 mg/g + 1 mg/g',
                    '250 mg/5 mL',
                    '12.5 mgc',
                    '175 mg',
                    '100 U/mL',
                    '1 mg/mL',
                    '200 mg/mL',
                    '0.5%',
                    '10% w/v',
                    '17%'
               ]),
            'dosage_form' => $this->faker->randomElement(
                [
                    'Tablets',
                    'Tablets',
                    'Tablets',
                    'Tablets',
                    'Tablets',
                    'Oral Solution',
                    'Injection',
                    'Injection',
                    'Injection',
                    'Intraperitoneal Injection',
                    'Eye drops',
                    'Cream',
                    'Ointment',
                    'Inhaler',
                    'Soluble Powder'
                ]),
            'therapeutic_properties' => $this->faker->randomElement(
                [
                    'Antibiotics',
                    'Antifungicals',
                    'Antiparasitics',
                    'Analgesics',
                    'Anesthetics',
                    'Anti-inflammatories',
                    'Antineoplastic'
                ]),
        ];
    }
}
