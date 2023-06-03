<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Seeder;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vaccine = Vaccine::create([
            'name'                   => 'Nobivac® Canine 1-DAPPv',
            'type'                   => 'Modified live virus (MLV)',
            'manufacturer'           => 'MSD',
            'description'            => 'A proven foundation for vaccine protocols. Canine 1-DAPPv is a combination vaccine approved for protection against canine distemper virus, adenovirus type 1 and 2, canine parainfluenza virus, and canine parvovirus.',
            'status'                 => 'Recommended',
            'dosage'                 => '1 ml',
            'administration'         => 'I.M., S.C.',
            'vaccination_schedule'   => 'Healthy dogs >= 6 weeks of age. Repeat 2-4 weeks later',
            'vaccination_doses'      => 2,
            'revaccination_schedule' => 'Every 1 — 3 years',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([1]);
        $vaccine->diseases()->attach([1, 2, 5, 7, 8]);


        $vaccine = Vaccine::create([
            'name'                   => 'Nobivac® L4',
            'type'                   => 'Modified live virus (MLV)',
            'manufacturer'           => 'MSD',
            'description'            => 'Canine leptospirosis is caused by bacteria spread in the urine of infected animals. There are a variety of serovars that may be responsible for disease as it occurs in dogs in the UK, and Europe. Nobivac L4 extends the range covered by dog vaccination to those  most commonly implicated in clinical cases throughout the UK and wider Europe.',
            'status'                 => 'Optional',
            'dosage'                 => '1 ml',
            'administration'         => 'S.C.',
            'vaccination_schedule'   => 'Healthy dogs >= 6 weeks of age. Repeat 2-4 weeks later.',
            'vaccination_doses'      => 2,
            'revaccination_schedule' => 'Every 1 — 3 years',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([1]);
        $vaccine->diseases()->attach([3]);

        $vaccine = Vaccine::create([
            'name'                   => 'Nobivac® DP PLUS',
            'type'                   => 'Modified live virus (MLV)',
            'manufacturer'           => 'MSD',
            'description'            => 'Nobivac DP PLUS offers the earliest protection against canine parvovirus and canine distemper virus for puppies. Nobivac DP PLUS avoids the concern of parvovirus maternally derived antibody (MDA) interference from as early as 4 weeks of age, providing high levels of immunity from 3 days post vaccination due to its very rapid onset of immunity for canine parvovirus (and 7 days for canine distemper virus), allowing for earlier phased socialisation with increased confidence.',
            'status'                 => 'Recommended',
            'dosage'                 => '1 ml',
            'administration'         => 'S.C.',
            'vaccination_schedule'   => 'Healthy dogs >= 4 weeks of age.',
            'vaccination_doses'      => 1,
            'revaccination_schedule' => null,
            'revaccination_doses'    => null
        ]);
        $vaccine->species()->attach([1]);
        $vaccine->diseases()->attach([1, 5]);

        $vaccine = Vaccine::create([
            'name'                   => 'Nobivac KC®',
            'type'                   => 'Modified live virus (MLV)',
            'manufacturer'           => 'MSD',
            'description'            => 'Nobivac KC provides immunisation against two significant causes of canine infectious respiratory disease (commonly referred to as kennel cough) and is recommended for any dogs that are regularly mixed or regularly come into contact with other dogs (e.g. kenneling, boarding, dog training etc.). Dogs at risk of this whooping cough-like syndrome benefit from vaccination against this very common and widespread threat.',
            'status'                 => 'Optional',
            'dosage'                 => '0.4 ml',
            'administration'         => 'I.N.',
            'vaccination_schedule'   => 'Healthy dogs >= 3 weeks of age.',
            'vaccination_doses'      => 1,
            'revaccination_schedule' => 'Every year',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([1]);
        $vaccine->diseases()->attach([8, 23]);

        $vaccine = Vaccine::create([
            'name'                   => 'NOBIVAC® 3-Rabies CA',
            'type'                   => 'Modified live virus (MLV)',
            'manufacturer'           => 'MSD',
            'description'            => 'This product has been shown to be effective for the vaccination of healthy dogs and cats 12 weeks of age or older against rabies. Duration of immunity of at least 3 years in dogs and cats has been demonstrated after repeat dose.',
            'status'                 => 'Required',
            'dosage'                 => '1 ml',
            'administration'         => 'S.C., or I.M, for dogs and S.C., for cats',
            'vaccination_schedule'   => 'Healthy animals >= 12 weeks of age. Repeat 1 year later',
            'vaccination_doses'      => 2,
            'revaccination_schedule' => 'Every 3 years (or as required by law)',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([1, 2]);
        $vaccine->diseases()->attach([6]);

        $vaccine = Vaccine::create([
            'name'                   => 'NOBIVAC® 1-RABIES',
            'type'                   => 'Modified live virus (MLV)',
            'manufacturer'           => 'MSD',
            'description'            => 'Effective for the vaccination of healthy dogs, cats, and ferrets, 12 weeks of age or older against rabies.',
            'status'                 => 'Required',
            'dosage'                 => '1 ml',
            'administration'         => 'S.C., or I.M, for dogs and S.C., for cats and ferrets',
            'vaccination_schedule'   => 'Healthy animals >= 12 weeks of age.',
            'vaccination_doses'      => 1,
            'revaccination_schedule' => 'Every year (or as required by law)',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([1, 2]);
        $vaccine->diseases()->attach([6]);

        $vaccine = Vaccine::create([
            'name'                   => 'NOBIVAC® 3-Rabies Vaccine',
            'type'                   => 'Modified live virus (MLV)',
            'manufacturer'           => 'MSD',
            'description'            => 'Provides protection against rabies in dogs and cats for at least three years, and ferrets for one year.',
            'status'                 => 'Required',
            'dosage'                 => '1 ml',
            'administration'         => 'S.C., or I.M, for dogs and S.C., for cats and ferrets',
            'vaccination_schedule'   => 'Healthy animals >= 12 weeks of age. Repeat 1 year later',
            'vaccination_doses'      => 2,
            'revaccination_schedule' => 'Dogs and cats every 3 years, ferrets every year (or as required by law)',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([1, 2]);
        $vaccine->diseases()->attach([6]);



        // $vaccine = Vaccine::create([
        //     'name'                   => 'CLOSTRIGEN® P',
        //     'type'                   => 'Virus inactivado',
        //     'manufacturer'           => 'Virbac',
        //     'description'            => 'Para prevenir las infecciones por C. chauvoei, C. septicum, C. noyvi tipo B, C. haemolyticum, C. perfringens tipo D, C. sordellii, Manheimia haemolytica y P. multocida tipo A.',
        //     'status'                 => 'Recommended',
        //     'dosage'                 => 'Bovinos: Administrar 5 ml. Ovinos y caprinos: 2 ml.',
        //     'administration'         => 'Intramuscular o subcutánea.',
        //     'vaccination_schedule'   => 'Edad: 15+ dias / +2 meses (madre vacunada). Repetir: [21, 30) días / [21, 30) días antes del parto.',
        //     'vaccination_doses'      => 2,
        //     'revaccination_schedule' => 'Anual o [21, 30) días antes del parto.',
        //     'revaccination_doses'    => 1
        // ]);
        // $vaccine->species()->attach([3, 4, 5]);
        // $vaccine->diseases()->attach([11, 12]);

        // $vaccine = Vaccine::create([
        //     'name'                   => 'TREMVAC-FP-CAV®',
        //     'type'                   => 'Virus activo',
        //     'manufacturer'           => 'MSD',
        //     'description'            => 'Para la inmunización de aves reproductoras como ayuda en la prevención de las enfermedades causadas por los virus de la Encefalomielitis Aviar y la Viruela Aviar, también protege contra el virus de la Anemia Infecciosa de las aves en la progenie de reproductoras vacunadas. Las aves debidamente vacunadas quedan protegidas durante todo el ciclo de postura.',
        //     'status'                 => 'Recommended',
        //     'dosage'                 => '0.01 ml',
        //     'administration'         => 'Punción en la membrana del ala.',
        //     'vaccination_schedule'   => 'Edad: 10 a 12 semanas',
        //     'vaccination_doses'      => 1,
        //     'revaccination_schedule' => 'No aplica',
        //     'revaccination_doses'    => 0
        // ]);
        // $vaccine->species()->attach([10]);
        // $vaccine->diseases()->attach([9, 10]);

        // $vaccine = Vaccine::create([
        //     'name'                   => 'COVEXIN® 10',
        //     'type'                   => 'Virus inactivado',
        //     'manufacturer'           => 'MSD',
        //     'description'            => 'Contra enfermedades ocasionadas por C. chauvoei, C. septicum, C. haemolyticum, C. novyi Tipo B, C. sordellii, C. tetani y C. perfringens tipos A, B, C y D.',
        //     'status'                 => 'Recommended',
        //     'dosage'                 => '2 ml',
        //     'administration'         => 'Subcutánea',
        //     'vaccination_schedule'   => 'Edad: 0+ días. Repetir: [4, 6) semanas.',
        //     'vaccination_doses'      => 2,
        //     'revaccination_schedule' => 'Anual',
        //     'revaccination_doses'    => 1
        // ]);
        // $vaccine->species()->attach([3, 4]);
        // $vaccine->diseases()->attach([11]);

        // $vaccine = Vaccine::create([
        //     'name'                   => 'BOBACT 8®',
        //     'type'                   => 'Virus inactivado',
        //     'manufacturer'           => 'MSD',
        //     'description'            => 'Para prevenir carbón sintomático, el edema maligno, la hepatitis necrótica infecciosa, la enterotoxemia, el riñon pulposo y la neumonia enzoótica.',
        //     'status'                 => 'Recommended',
        //     'dosage'                 => 'Bovinos: 2 ml, ovinos y caprinos: 2.5ml',
        //     'administration'         => 'Intramuscular',
        //     'vaccination_schedule'   => 'Edad: 3+ meses. Repetir: [3, 4) semanas.',
        //     'vaccination_doses'      => 2,
        //     'revaccination_schedule' => '6 meses',
        //     'revaccination_doses'    => 1
        // ]);
        // $vaccine->species()->attach([3, 4, 5]);
        // $vaccine->diseases()->attach([12, 14, 15, 16, 17, 18]);

        // $vaccine = Vaccine::create([
        //     'name'                   => 'BOVILIS® RB-51',
        //     'type'                   => 'Virus inactivado',
        //     'manufacturer'           => 'MSD',
        //     'description'            => 'Previene infecciones y abortos causados por Brucella abortus.',
        //     'status'                 => 'Required',
        //     'dosage'                 => '2 ml',
        //     'administration'         => 'Subcutánea',
        //     'vaccination_schedule'   => 'Hembras. Edad: 3+ meses.',
        //     'vaccination_doses'      => 1,
        //     'revaccination_schedule' => 'No aplica',
        //     'revaccination_doses'    => 0
        // ]);
        // $vaccine->species()->attach([3]);
        // $vaccine->diseases()->attach([13]);

        // $vaccine = Vaccine::create([
        //     'name'                   => 'BOVILIS® VISTA 5 L5 SQ',
        //     'type'                   => 'Virus inactivado',
        //     'manufacturer'           => 'MSD',
        //     'description'            => 'Previene las enfermedades causadas por IBR, BVD (Tipo 2), BRSV; como una ayuda en el control de las enfermedades causadas por BVD (Tipo 1) y PI3; para prevenir la leptospirosis causada por L. canicola, L. gryppotyphosa, L. hardjo, L. icterohaemorrhagiae y L. Pomona así como en la prevención de la eliminación en orina de organismos de L. hardjo. ',
        //     'status'                 => 'Optional',
        //     'dosage'                 => '2 ml',
        //     'administration'         => 'Subcutánea',
        //     'vaccination_schedule'   => 'Hembras. Edad: 6+ meses. Aplicar: [14-60) días antes de la monta.',
        //     'vaccination_doses'      => 1,
        //     'revaccination_schedule' => '14-60 días antes de la monta',
        //     'revaccination_doses'    => 1
        // ]);
        // $vaccine->species()->attach([3]);
        // $vaccine->diseases()->attach([19, 20, 21, 22]);
    }
}
