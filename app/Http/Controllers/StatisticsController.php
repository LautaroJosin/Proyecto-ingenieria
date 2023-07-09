<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\AdoptionDogStatistics;
use App\Charts\AppointmentStatistics;
use App\Charts\LostDogStatistics;

class StatisticsController extends Controller
{
    /* Redirije a la vista con las estadisticas de perros en adopción */
    public function index(AdoptionDogStatistics $chart)
    {
        return view('statistics.indexAdoptionDog', ['chart' => $chart->build()]);   
    }

    /* Redirije a la vista con las estadisticas de turnos */
    public function index2(AppointmentStatistics $chart)
    {
        return view('statistics.indexAppointment', ['chart' => $chart->build()]);   
    }

    /* Redirije a la vista con las estadisticas de turnos */
    public function index3(LostDogStatistics $chart)
    {
        return view('statistics.indexLostDog', ['chart' => $chart->build()]);   
    }
}
