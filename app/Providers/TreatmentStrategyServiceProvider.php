<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Treatment\Deworming;
use App\Treatment\TreatmentStrategy;
use App\Treatment\vaccineAgainstDiseases;
use App\Treatment\Others;
use App\Models\Appointment;


class TreatmentStrategyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TreatmentStrategy::class, function ($app) {
            $request = $app->make('request');
            $appointment = Appointment::find($request->appointment_id);
            $treatment = $appointment->reason->reason;

            switch ($treatment) {
                case 'Vacuna contra enfermedades':
                    return new vaccineAgainstDiseases();
                    break;
                case 'Desparasitación':
                    return new Deworming();
                    break;
                default:
                    return new Others();
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
