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
         * toDO:
         *
         *  ✓✓ Consultation details:
         *      a) Crear permisos para subir, eliminar y descargar imágenes y tests de laboratorio en las consultas.
         *      b) Estilizar el ocntenedor de imagenes / tests en el componente
         *  ✓✓ Revisar todos los <a> de todos los componentes:
         *      a) los que utilizan el atributo target para agregar el rel="noopener noreferrer" y
         *      b) href="javascript:void(0)" cuando aplique.
         *  ✓✓ Arreglar la validación para los tests en ConsultationDetails.
         *  ✓✓ Arreglar lo relacionado con el editor WYSIWYG en las consultas.
         *  ✓✓ Agregar el sppiner al botón del modal de los formularios.
         *  ✓✓ Agregar el componente/modelo, etc., para desparasitantes.
         *  ✓✓ Agregar el componente/modelo, etc., para desparacitaciones.
         *  ✓✓ Completar el feedback positivo a los formularios
         *  ✓✓ Volver nullable el campo name de las pet
         *
         *
         *  — Agregar el compo presuntive en Consultation model.
         *  — Agregar al modelo consultations la especialidad
         *
         *  — Verificar y corregir si es necesario los permisos de las consultas.
         *  — Buscar mejores opciones para mostra/ocultar los botones save/update de los formularios
         *  — Arreglar el algoritmo de nextConsultation y previousConsultation (se brinca consultas)
         *  — Agregar el componente/modelo, etc., para prescipciones.
         *  — Implementar la funcionalidad para pactar citas.
         *  — Agregar la opción de cambiar el dueño de la pet.
         *
         **/

        /**
         * — Lista de vistas:
         *      ✓ users component
         *      ✓ user.show
         *      ✓ pets.show, modal-image
         *      ✓ vaccinations component
         *      ✓ consultations component
         *      ✓ consultation details component
         *      ✓ species component
         *      ✓ vaccine component
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
