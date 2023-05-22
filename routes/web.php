<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDogController;
use App\Http\Controllers\AdminDogController;
use App\Http\Controllers\UserAppointmentController;
use App\Http\Controllers\AdminAppointmentController;
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


Route::resource('user/dog', UserDogController::class)->only('index')->names([
    'index'=>'my-dog.index'
]);

Route::resource('dog/treatment', TreatmentController::class)->only('show', 'create', 'store')
    ->parameters(['treatment' => 'dog',]);

Route::resource('admin/dog', AdminDogController::class)->except('show');

Route::resource('user/appointment', UserAppointmentController::class)->only('index', 'create', 'store');

Route::post('admin/appointment/sendMail/{appointment}', AdminAppointmentController::class . '@sendMail')->name('appointment.sendMail');

Route::resource('admin/appointment', AdminAppointmentController::class)->except('show', 'create', 'store');
