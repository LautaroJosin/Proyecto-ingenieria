<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDogController;
use App\Http\Controllers\AdminDogController;
use App\Http\Controllers\UserAppointmentController;
use App\Http\Controllers\AdminAppointmentController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\AdoptionDogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('user/dog', UserDogController::class)->only('index')->names([
    'index'=>'my-dog.index'
]);

Route::get('dog/treatment/create/{appointment}', [TreatmentController::class, 'create'])->name('treatment.create');
Route::resource('dog/treatment', TreatmentController::class)->only('show', 'store')
    ->parameters(['treatment' => 'dog',]);

Route::resource('admin/dog', AdminDogController::class)->except('show');

Route::name('user.')->group(function () {
    Route::resource('user/appointment', UserAppointmentController::class)->only('index', 'create', 'store');
});


Route::post('admin/appointment/sendMail/{appointment}', AdminAppointmentController::class . '@sendMail')->name('appointment.sendMail');

Route::resource('admin/appointment', AdminAppointmentController::class)->except('show', 'create', 'store');



/* ============== Adoption ============== */

Route::get('adoption/userDogs', [AdoptionDogController::class,'userDogs'])->name('adoption.userdogs');

Route::resource('adoption', AdoptionDogController::class)->except('show');

Route::get('adoption/filter', [AdoptionDogController::class , 'filter'])->name('adoption.filter');

Route::post('adoption/adoptNotAuthenticated', [AdoptionDogController::class , 'guestAdoption'])->name('adoption.adoptNotAuthenticated');
Route::post('adoption/adoptAuthenticated/{owner_id}/{dog_name}', [AdoptionDogController::class , 'authAdoption'])->name('adoption.adoptAuthenticated');

Route::put('adoption/confirm-adoption/{dog_identifier}', [AdoptionDogController::class , 'confirmAdoption'])->name('adoption.confirm');
Route::put('adoption/{adoption}/{dog_identifier}', [AdoptionDogController::class , 'update'])->name('myadoption.update');

/* ====================================== */