<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PetProfileController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Livewire\AssignPermissionsController;
use App\Http\Livewire\PermissionController;
use App\Http\Livewire\RoleController;
use App\Http\Livewire\TrashController;
use App\Http\Livewire\UserController;
use Illuminate\Support\Facades\Route;



Route::get('', [HomeController::class, 'index'])->name('admin.index');

// User
Route::get('users', UserController::class)->name('admin.users');
Route::get('users/trash', TrashController::class)->name('admin.users.recycle-bin');
Route::get('users/{user}', [UserProfileController::class, 'show'])->name('admin.users.show');

// Pets
Route::get('pets/{pet}', [PetProfileController::class, 'show'])->name('admin.pets.show');

//Roles
Route::get('roles', RoleController::class)->name('admin.roles');

//Permissions
Route::get('permissions', PermissionController::class)->name('admin.permissions');

// Assign Permissions
Route::get('assign-permissions', AssignPermissionsController::class)->name('admin.assign-permissions');

// Credits route
Route::get('credits', function(){
	return view('admin.credits');
})->name('admin.credits');
