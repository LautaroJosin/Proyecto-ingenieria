<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\AdoptionDogStatistics;

class StatisticsController extends Controller
{
    public function index(AdoptionDogStatistics $chart)
    {
        return view('statistics.indexAdoptionDog', ['chart' => $chart->build()]);   
    }
}
