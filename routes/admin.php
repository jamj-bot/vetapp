<?php

// use App\Http\Controllers\Admin\ConsultationController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PetProfileController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Livewire\AssignPermissionsController;
use App\Http\Livewire\ConsultationController;
use App\Http\Livewire\ConsultationDetailsController;
use App\Http\Livewire\PermissionController;
use App\Http\Livewire\RoleController;
use App\Http\Livewire\SpeciesController;
use App\Http\Livewire\TrashController;
use App\Http\Livewire\UserController;
use App\Http\Livewire\VaccineController;
use Illuminate\Support\Facades\Route;



Route::get('', [HomeController::class, 'index'])->name('admin.index');

// User
Route::get('users', UserController::class)->name('admin.users');
Route::get('users/{user}', [UserProfileController::class, 'show'])->name('admin.users.show');

// Trash
Route::get('trash', TrashController::class)->name('admin.recycle-bin');

// Pets
Route::get('pets/{pet}', [PetProfileController::class, 'show'])->name('admin.pets.show');

// Consultations
Route::get('pets/{pet}/consultations', ConsultationController::class)->name('admin.pets.consultations');
Route::get('pets/{pet}/consultations/{consultation}', ConsultationDetailsController::class)->name('admin.pets.consultations.show');

//Roles
Route::get('roles', RoleController::class)->name('admin.roles');

//Permissions
Route::get('permissions', PermissionController::class)->name('admin.permissions');

// Assign Permissions
Route::get('assign-permissions', AssignPermissionsController::class)->name('admin.assign-permissions');

// Species
Route::get('species', SpeciesController::class)->name('admin.species');

// Species
Route::get('vaccines', VaccineController::class)->name('admin.vaccines');

// Credits route
Route::get('credits', function(){
	return view('admin.credits');
})->name('admin.credits');
