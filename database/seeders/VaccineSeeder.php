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
        Vaccine::create([
            'recommended_for'        => 'Bovinos, Ovinos',
            'name'                   => 'COVEXIN® 10',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Contra enfermedades ocasionadas por C. chauvoei, C. septicum, C. haemolyticum, C. novyi Tipo B, C. sordellii, C. tetani y C. perfringens tipos A, B, C y D.',
            'dose'                   => '2 ml',
            'administration'         => 'Subcutánea',
            'primary_vaccination'    => 'Edad: 0+ días. Repetir: [4, 6) semanas.',
            'primary_doses'          => 2,
            'revaccination_interval' => 'Anual',
            'revaccination_doses'    => 1
        ]);

        Vaccine::create([
            'recommended_for'        => 'Bovinos, Ovinos, Caprinos',
            'name'                   => 'BOBACT 8®',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Para prevenir carbón sintomático, el edema maligno, la hepatitis necrótica infecciosa, la enterotoxemia, el riñon pulposo y la neumonia enzoótica.',
            'dose'                   => 'Bovinos: 2 ml, ovinos y caprinos: 2.5ml',
            'administration'         => 'Intramuscular',
            'primary_vaccination'    => 'Edad: 3+ meses. Repetir: [3, 4) semanas.',
            'primary_doses'          => 2,
            'revaccination_interval' => '6 meses',
            'revaccination_doses'    => 1
        ]);

        Vaccine::create([
            'recommended_for'        => 'Bovinos (hembras)',
            'name'                   => 'BOVILIS® RB-51',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Previene infecciones y abortos causados por Brucella abortus.',
            'dose'                   => '2 ml',
            'administration'         => 'Subcutánea',
            'primary_vaccination'    => 'Hembras. Edad: 3+ meses.',
            'primary_doses'          => 1,
            'revaccination_interval' => 'Una vez en la vida',
            'revaccination_doses'    => 0
        ]);

        Vaccine::create([
            'recommended_for'        => 'Bovinos (hembras)',
            'name'                   => 'BOVILIS® VISTA 5 L5 SQ',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Previene las enfermedades causadas por IBR, BVD (Tipo 2), BRSV; como una ayuda en el control de las enfermedades causadas por BVD (Tipo 1) y PI3; para prevenir la leptospirosis causada por L. canicola, L. gryppotyphosa, L. hardjo, L. icterohaemorrhagiae y L. Pomona así como en la prevención de la eliminación en orina de organismos de L. hardjo. ',
            'dose'                   => '2 ml',
            'administration'         => 'Subcutánea',
            'primary_vaccination'    => 'Hembras. Edad: 6+ meses. Aplicar: [14-60) días antes de la monta.',
            'primary_doses'          => 1,
            'revaccination_interval' => '14-60 días antes de la monta',
            'revaccination_doses'    => 1
        ]);

        Vaccine::create([
            'recommended_for'        =>  'Perros',
            'name'                   => 'NOBIVAC® DAPPv+L4',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Previene enfermedad y mortalidad causadas por L. canicola, L. icterohaemorrhagiae, L. pomona y L. grippotyphosa; la prevención de leptospiruria (eliminación de Leptospira en orina) causada por L. canicola, L. icterohaemorrhagiae, y L. grippotyphosa; y como ayuda en la prevención de leptospiruria causada por L. pomona.',
            'dose'                   => '1 ml',
            'administration'         => 'Subcutánea',
            'primary_vaccination'    => 'Edad: 8+ semanas. Repetir: [2, 4) semanas.',
            'primary_doses'          => 3,
            'revaccination_interval' => 'Anual',
            'revaccination_doses'    => 1
        ]);

        Vaccine::create([
            'recommended_for'        => 'Perros, Gatos, Hurones',
            'name'                   => 'NOBIVAC® RABIA',
            'type'                   => 'Virus inactivado',
            'manufacturer'           => 'MSD',
            'description'            => 'Para la inmunización activa contra la rabia de perros, gatos y hurones.',
            'dose'                   => '1 ml',
            'administration'         => 'Perros y gatos: subcutánea o intramuscular, hurones: subcutánea.',
            'primary_vaccination'    => 'Edad: 3+ meses.',
            'primary_doses'          => 1,
            'revaccination_interval' => 'Anual',
            'revaccination_doses'    => 1
        ]);

    }
}
