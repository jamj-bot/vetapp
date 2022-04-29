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
            'name'                   => 'COVEXIN® 10',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Contra enfermedades ocasionadas por C. chauvoei, C. septicum, C. haemolyticum, C. novyi Tipo B, C. sordellii, C. tetani y C. perfringens tipos A, B, C y D.',
            'status'                 => 'Recommended',
            'dosage'                 => '2 ml',
            'administration'         => 'Subcutánea',
            'vaccination_schedule'   => 'Edad: 0+ días. Repetir: [4, 6) semanas.',
            'primary_doses'          => 2,
            'revaccination_schedule' => 'Anual',
            'revaccination_doses'    => 1
        ]);
        // Uso la relación para definir a qué especies está relacionada la vacuna
        $vaccine->species()->attach([3, 4]);

        $vaccine = Vaccine::create([
            'name'                   => 'BOBACT 8®',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Para prevenir carbón sintomático, el edema maligno, la hepatitis necrótica infecciosa, la enterotoxemia, el riñon pulposo y la neumonia enzoótica.',
            'status'                 => 'Recommended',
            'dosage'                 => 'Bovinos: 2 ml, ovinos y caprinos: 2.5ml',
            'administration'         => 'Intramuscular',
            'vaccination_schedule'   => 'Edad: 3+ meses. Repetir: [3, 4) semanas.',
            'primary_doses'          => 2,
            'revaccination_schedule' => '6 meses',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([3, 4, 5]);

        $vaccine = Vaccine::create([
            'name'                   => 'BOVILIS® RB-51',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Previene infecciones y abortos causados por Brucella abortus.',
            'status'                 => 'Recommended',
            'dosage'                 => '2 ml',
            'administration'         => 'Subcutánea',
            'vaccination_schedule'   => 'Hembras. Edad: 3+ meses.',
            'primary_doses'          => 1,
            'revaccination_schedule' => 'Una vez en la vida',
            'revaccination_doses'    => 0
        ]);
        $vaccine->species()->attach([3]);

        $vaccine = Vaccine::create([
            'name'                   => 'BOVILIS® VISTA 5 L5 SQ',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Previene las enfermedades causadas por IBR, BVD (Tipo 2), BRSV; como una ayuda en el control de las enfermedades causadas por BVD (Tipo 1) y PI3; para prevenir la leptospirosis causada por L. canicola, L. gryppotyphosa, L. hardjo, L. icterohaemorrhagiae y L. Pomona así como en la prevención de la eliminación en orina de organismos de L. hardjo. ',
            'status'                 => 'Optional',
            'dosage'                 => '2 ml',
            'administration'         => 'Subcutánea',
            'vaccination_schedule'   => 'Hembras. Edad: 6+ meses. Aplicar: [14-60) días antes de la monta.',
            'primary_doses'          => 1,
            'revaccination_schedule' => '14-60 días antes de la monta',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([3]);

        $vaccine = Vaccine::create([
            'name'                   => 'NOBIVAC® DAPPv+L4',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Previene enfermedad y mortalidad causadas por L. canicola, L. icterohaemorrhagiae, L. pomona y L. grippotyphosa; la prevención de leptospiruria (eliminación de Leptospira en orina) causada por L. canicola, L. icterohaemorrhagiae, y L. grippotyphosa; y como ayuda en la prevención de leptospiruria causada por L. pomona.',
            'status'                 => 'Optional',
            'dosage'                 => '1 ml',
            'administration'         => 'Subcutánea',
            'vaccination_schedule'   => 'Edad: 8+ semanas. Repetir: [2, 4) semanas.',
            'primary_doses'          => 3,
            'revaccination_schedule' => 'Anual',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([1]);

        $vaccine = Vaccine::create([
            'name'                   => 'NOBIVAC® RABIA',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Para la inmunización activa contra la rabia de perros, gatos y hurones.',
            'status'                 => 'Recommended',
            'dosage'                 => '1 ml',
            'administration'         => 'Perros y gatos: subcutánea o intramuscular, hurones: subcutánea.',
            'vaccination_schedule'   => 'Edad: 3+ meses.',
            'primary_doses'          => 1,
            'revaccination_schedule' => 'Anual',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([1, 2]);

        $vaccine = Vaccine::create([
            'name'                   => 'Rabigen® GE',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'Virbac',
            'description'            => 'La inmunización contra la Rabia Paralítica o Derriengue en bovinos y equinos sanos, en suspensión lista para aplicarse.',
            'status'                 => 'Recommended',
            'dosage'                 => '2 ml',
            'administration'         => 'Intramuscular profunda exclusivamente.',
            'vaccination_schedule'   => 'Edad: 0+ dias.',
            'primary_doses'          => 1,
            'revaccination_schedule' => 'Anual',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([3, 4, 5]);

        $vaccine = Vaccine::create([
            'name'                   => 'CLOSTRIGEN® P',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'Virbac',
            'description'            => 'Para prevenir las infecciones por C. chauvoei, C. septicum, C. noyvi tipo B, C. haemolyticum, C. perfringens tipo D, C. sordellii, Manheimia haemolytica y P. multocida tipo A.',
            'status'                 => 'Recommended',
            'dosage'                 => 'Bovinos: Administrar 5 ml. Ovinos y caprinos: 2 ml.',
            'administration'         => 'Intramuscular o subcutánea.',
            'vaccination_schedule'   => 'Edad: 15+ dias / +2 meses (madre vacunada). Repetir: [21, 30) días / [21, 30) días antes del parto.',
            'primary_doses'          => 2,
            'revaccination_schedule' => 'Anual / [21, 30) días antes del parto.',
            'revaccination_doses'    => 1
        ]);
        $vaccine->species()->attach([3, 4, 5]);
    }
}
