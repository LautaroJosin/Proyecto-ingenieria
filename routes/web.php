<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DogController;
use App\Http\Controllers\UserAppointmentController;
use App\Http\Controllers\AdminAppointmentController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\TreatmentController;

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


//=============Dog==============
Route::resource('dog', DogController::class)->except('show'); 
//==============================

//==========Treatments==========
Route::resource('appointment.treatment', TreatmentController::class)->only('create', 'store')->names([
    'create'=>'treatment.create',
    'store'=>'treatment.store'
]);
Route::resource('dog.treatment', TreatmentController::class)->only('index')->names([
    'index'=>'treatment.index'
]);
//==============================

Route::name('user.')->group(function () {
    Route::resource('user/appointment', UserAppointmentController::class)->only('index', 'create', 'store');
});


Route::post('admin/appointment/sendMail/{appointment}', AdminAppointmentController::class . '@sendMail')->name('appointment.sendMail');

Route::resource('admin/appointment', AdminAppointmentController::class)->except('show', 'create', 'store');


//==========Caregiver==========
Route::resource('caregiver', CaregiverController::class)->except('show');
Route::name('caregiver')->group(function () {
    Route::post('caregiver/enable/{caregiver}', CaregiverController::class . '@enable')->name('.enable');
    Route::post('caregiver/disable/{caregiver}', CaregiverController::class . '@disable')->name('.disable');
});
//============================== 