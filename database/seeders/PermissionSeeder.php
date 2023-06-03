<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * To do:
         *
         *  — Agregar al modelo consultations la especialidad?
         *  — Revisar el problema con la validación del componente change owner.
         *  — Buscar mejores opciones para mostra/ocultar los botones save/update de los formularios
         *  — Implementar la funcionalidad para pactar citas.
         *  — Que se pueda revisar por cada veterinario: las consultas /rrecetas que ha creado en total y en determinado periodo.
         *  — Revisar porqué no se esán subiendo las iamgenes con el factory
         *  — Overdue vaccination reminder, checkup
         *  — Export dewormings
         *
         *  — Perfeccionar la validación del array de arrays de instructions mando al método CreateMany:
         *      Ejemplo de cómo agregar reglas de validación condicionalmente:
         *      https://laracasts.com/discuss/channels/laravel/multiple-required-if-within-a-validators-rule
         *
         *  — Mejorar la accesibilidad de las tablas con <caption>, rowspan, <scope>, etc.

         *  — Mejorar texto de los toast:
         *      - Ejemplo de texto escrito correctamente: Record added succesfully.
         *
         *  — Refactorizar / estandarizar la utilización de Toast / Sweet Alert:
         *      - Utilizar un Sweet alert en el caso de que vaya a realizar un force delete ("Esta opción no se puede deshacer").
         *      - Utilizar un toast en caso de que se vaya a realizar un delete ("Se envió a Recycle bin").
         *
         *  — Rediseñar la sección de Recycle bin

         *  — Permisos nuevos para nuevas funcionalidades

         *  — Agregar el atributo 'genero' al modelo Species, con las opciones: Mamifero, ave, reptil, anfibio, peces, invertebrado.
         *       https://www.vetcon.es/invertebrados-exoticos/
         **/


        /**
         *  — https://www.researchgate.net/publication/305679921_Practical_Manual_on_Veterinary_Clinical_Diagnostic_Approach
         *  — ROUTES OF DRUG ADMINISTRATION: Oral administration OA, intravenous route IV, intramuscular IM, intradernal
         *       route ID, epidural route, subconjuntival, topical or local application.
         *  — DIAGNOSIS: clinical diagnosis, laboratory diagnosis, radiology or tissue diagnosis, principal diagnosis, admitting
         *       diagnosis, other
         *
         *  — https://www.slideshare.net/SUNYUlsterInstructs/veterinary-drug-use-prescribing-acquisition-and-pharmacy-management
         *  — PRESCRIPTION FIELDS:
         *      -hospital name and address,
         *      -vet name, cédula profesional,
         *      -drug name, strength, and quantity (metronidazol, 10 mg, tablets, QTY 14),
         *      -date of the order, directions for use, any refill information (if warranted)

         *  — $users = User::role('writer')->get(); // Returns only users with the role 'writer'
         *  — Buscar la manera de ordeyBy relationship en many to many
         *  — Buscar la manera de implementar el modo softdelete en el modelo Permission


         *  — https://www.merck-animal-health-usa.com/nobivac/nobivac-feline-1-hcp

         **/

        /**
         * — Lista de vistas:
         *      ✓ users component
         *      ✓ user.show
         *      ✓ pets.show
         *          ✓ vaccinations component
         *          ✓ dewormings component
         *          ✓ consultations component
         *          ✓ consultation details component
         *      ✓ species component
         *      ✓ vaccine component
         *      ✓ parasiticide component
         *      ✓ trash component
         *      ✓ permission component
         *      ✓ role component
         *      ✓ assign permissions component
         **/

        /**
         *  role 1 = superadmin
         *  role 2 = admin
         *  role 3 = client
         *  role 4 = veterinarian
         *  role 5 = guest
         *
         * 1 =  perro
         * 2 =  gato
         * 3 =  bovino
         * 4 =  ovino
         * 5 =  caprino
         * 6 =  conejo
         * 7 =  caballo
         * 8 =  procino
         * 9 =  bufalino
         * 10 = avestruz
         **/

        //------ Vaccines permissions ------
        Permission::create([
            'name' => 'consultations_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_restore'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_show'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_destroy'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_delete'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_export'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_save_files'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_download_files'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'consultations_delete_files'
        ])->syncRoles(1);

        //------ Prescriptions permissions ------
        Permission::create([
            'name' => 'prescriptions_void'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'prescriptions_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'prescriptions_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'prescriptions_export'
        ])->syncRoles(1);

        //------ Vaccines permissions ------
        Permission::create([
            'name' => 'vaccines_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccines_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccines_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccines_destroy'
        ])->syncRoles(1);


        //------ Vaccinations permissions ------
        Permission::create([
            'name' => 'vaccinations_apply'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccinations_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccinations_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccinations_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccinations_destroy'
        ])->syncRoles(1);

        //------ Dewormings permissions ------
        Permission::create([
            'name' => 'dewormings_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'dewormings_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'dewormings_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'dewormings_destroy'
        ])->syncRoles(1);

        //------ Species permissions ------
        Permission::create([
            'name' => 'species_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'species_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'species_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'species_destroy'
        ])->syncRoles(1);

        //------ Vaccines permissions ------
        Permission::create([
            'name' => 'pets_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'pets_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'pets_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'pets_show'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'pets_destroy'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'pets_change_owner'
        ])->syncRoles(1);

        //------ Vaccines permissions ------
        Permission::create([
            'name' => 'parasiticides_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'parasiticides_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'parasiticides_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'parasiticides_show'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'parasiticides_destroy'
        ])->syncRoles(1);

        //------ Users permissions ------
        Permission::create([
            'name' => 'users_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'users_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'users_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'users_destroy'
        ])->syncRoles(1);


        //------ Roles permissions ------
        Permission::create([
            'name' => 'roles_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'roles_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'roles_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'roles_destroy'
        ])->syncRoles(1);

        //------ Permissions permissions ------
        Permission::create([
            'name' => 'permissions_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'permissions_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'permissions_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'permissions_destroy'
        ])->syncRoles(1);

        //------ Assing permissions permissions ------
        Permission::create([
            'name' => 'assign_permissions_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'assign_permissions_sync'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'assign_permissions_revoke_all'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'assign_permissions_sync_all'
        ])->syncRoles(1);

        //------ Appointments permissions ------
        Permission::create([
            'name' => 'appointments_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'appointments_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'appointments_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'appointments_destroy'
        ])->syncRoles(1);

        //------ Trash permissions ------
        Permission::create([
            'name' => 'trash_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'trash_restore'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'trash_destroy'
        ])->syncRoles(1);

        //------ UserProfile permission ------
        Permission::create([
            'name' => 'user_profile_show'
        ])->syncRoles(1);
    }
}
