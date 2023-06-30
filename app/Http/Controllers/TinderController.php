<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;

class TinderController extends Controller
{
    public function index()
    {
        $myTinderDogs = Dog::where('user_id', auth()->user()->id)
            ->where('is_on_tinder', true)
            ->get();

        $recomendedDogs = collect();

        foreach ($myTinderDogs as $dog) {
            $currentDogYear = $dog->date_of_birth->format('Y');
            $twoYearsAgo = $currentDogYear - 2;
            $twoYearsLater = $currentDogYear + 2;

            $dogsInRange = Dog::where('is_on_tinder', true)
                ->where('user_id', '!=', auth()->user()->id)
                ->where('race', $dog->race)
                ->where('gender', '!=', $dog->gender)
                ->whereRaw("YEAR(date_of_birth) BETWEEN $twoYearsAgo AND $twoYearsLater")
                ->get();

            $recomendedDogs = $recomendedDogs->concat($dogsInRange);
        }

        $recomendedDogs = $recomendedDogs->unique('id');
        
        return view('tinder.index')->with('dogs', $recomendedDogs);
    }

    public function filter()
    {
        return view('tinder.index');
    }
}
