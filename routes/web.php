<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DogController;
use App\Http\Controllers\UserAppointmentController;
use App\Http\Controllers\AdminAppointmentController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdoptionDogController;
use App\Http\Controllers\LostDogController;
use App\Http\Controllers\DonationCampaignController;

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

//==========Treatments==========
Route::resource('appointment.treatment', TreatmentController::class)->only('create', 'store')->names([
    'create'=>'treatment.create',
    'store'=>'treatment.store'
]);
Route::resource('dog.treatment', TreatmentController::class)->only('index')->names([
    'index'=>'treatment.index'
]);

//========Appointments==========
Route::name('user.')->group(function () {
    Route::resource('user/appointment', UserAppointmentController::class)->only('index', 'create', 'store');
});

Route::get('appointment/filter', [AppointmentController::class, 'filter'])->name('appointment.filter');

Route::prefix('admin/appointment')->group(function () {
    Route::name('admin.appointment.')->group(function () {
        Route::controller(AdminAppointmentController::class)->group(function () {
            Route::patch('{appointment}/confirm', 'confirm')->name('confirm');
            Route::patch('{appointment}/cancel', 'cancel')->name('cancel');
            Route::patch('{appointment}/missing', 'missing')->name('missing');
            Route::get('{appointment}/reject', 'reject')->name('reject');
            Route::post('{appointment}/reject', 'sendMail')->name('sendMail');
        });
    });
});
Route::resource('admin/appointment', AdminAppointmentController::class)->only('index');

//==========Caregiver==========
Route::resource('caregiver', CaregiverController::class)->except('show');
Route::name('caregiver')->group(function () {
    Route::post('caregiver/enable/{caregiver}', [CaregiverController::class, 'enable'])->name('.enable');
    Route::post('caregiver/disable/{caregiver}', [CaregiverController::class, 'disable'])->name('.disable');
    Route::get('caregiver/filter', [CaregiverController::class, 'filter'])->name('.filter');
});
//============================== 

Route::resource('admin/appointment', AdminAppointmentController::class)->except('show', 'create', 'store');

//==========Adoption===========

Route::get('adoption/userDogs', [AdoptionDogController::class,'userDogs'])->name('adoption.userdogs');

Route::resource('adoption', AdoptionDogController::class)->except('show');

Route::get('adoption/filter', [AdoptionDogController::class , 'filter'])->name('adoption.filter');

Route::post('adoption/adoptNotAuthenticated', [AdoptionDogController::class , 'guestAdoption'])->name('adoption.adoptNotAuthenticated');

Route::post('adoption/adoptAuthenticated/{owner_id}/{dog_name}', [AdoptionDogController::class , 'authAdoption'])->name('adoption.adoptAuthenticated');

Route::put('adoption/confirm-adoption/{dog_identifier}', [AdoptionDogController::class , 'confirmAdoption'])->name('adoption.confirm');

Route::put('adoption/{adoption}/{dog_identifier}', [AdoptionDogController::class , 'update'])->name('myadoption.update');

//===========LostDog===========

Route::resource('lostDog', LostDogController::class)->except('show', 'store');
Route::name('lostDog')->group(function() {
    Route::get('lostDog/foundIndex', [LostDogController::class, 'foundIndex'])->name('.foundIndex');
    Route::get('lostDog/myLostDogsIndex/', [LostDogController::class, 'myLostDogsIndex'])->name('.myLostDogsIndex');
    Route::get('lostDog/myFoundDogsIndex', [LostDogController::class, 'myFoundDogsIndex'])->name('.myFoundDogsIndex');
    Route::get('lostDog/filterLost', [LostDogController::class, 'filterLost'])->name('.filterLost');
    Route::get('lostDog/filterFound', [LostDogController::class, 'filterFound'])->name('.filterFound');
    Route::get('lostDog/filterMyDogs/{type}', [LostDogController::class, 'filterMyDogs'])->name('.filterMyDogs');
    Route::get('lostDog/foundCreate', [LostDogController::class, 'foundCreate'])->name('.foundCreate');
    Route::post('lostDog/store/{type}', [LostDogController::class, 'store'])->name('.store');
    Route::post('lostDog/{lostDog}/found', [LostDogController::class, 'found'])->name('.found');
    Route::post('lostDog/{lostDog}/reunited', [LostDogController::class, 'reunited'])->name('.reunited');
});

//===== DonationCampaigns ======

/* ============== DonationCampaigns ============== */

Route::resource('donation-campaign', DonationCampaignController::class)->only('index', 'create', 'store', 'edit', 'update')
    ->parameters([
        'donation-campaign' => 'campaign',
    ]);

Route::put('donation-campaign/process-donation/{campaign_id}' , [DonationCampaignController::class, 'processDonation'])
    ->name('donation-campaign.proccessDonation');

Route::get('donation-campaign/donate/{campaign_id}' , [DonationCampaignController::class, 'donate'])
    ->name('donation-campaign.donate');
