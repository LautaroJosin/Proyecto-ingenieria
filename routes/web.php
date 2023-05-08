<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DogController;
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
});


Route::controller(DogController::class)->group(function () {
    Route::prefix('/usuario/perros')->group(function () {
        Route::name('dog.')->group(function () {
            Route::get('', 'index')->name('');
            Route::post('', 'store')->name('store');
            Route::get('/crear', 'create')->name('create');
            Route::delete('/borrar/{id}', 'destroy')->name('destroy');
            Route::get('/libreta/{id}', 'showHealthBook')->name('showHealthBook'); //Después se implementará. Se usará un singleton
        });
    });
});
