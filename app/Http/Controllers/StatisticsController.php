<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\AdoptionDogStatistics;
use App\Charts\AppointmentStatistics;
use App\Charts\LostDogStatistics;

class StatisticsController extends Controller
{

    /* Redirije al menu principal de estadisticas*/
    public function index()
    {
        return view('statistics.index');   
    }

    /* Redirije a la vista con las estadisticas de perros en adopción */
    public function showStatisticsAdopDog(AdoptionDogStatistics $chart)
    {
        return view('statistics.indexAdoptionDog', ['chart' => $chart->build()]);   
    }

    /* Redirije a la vista con las estadisticas de turnos */
    public function showStatisticsAppoint(AppointmentStatistics $chart)
    {
        return view('statistics.indexAppointment', ['chart' => $chart->build()]);   
    }

    /* Redirije a la vista con las estadisticas de turnos */
    public function showStatisticsLostDog(LostDogStatistics $chart)
    {
        return view('statistics.indexLostDog', ['chart' => $chart->build()]);   
    }
}
