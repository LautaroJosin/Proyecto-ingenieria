<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;

class TinderController extends Controller
{
    public function index()
    {
        $myTinderDogs = $this->getMyTinderDogs();

        $recomendedDogs = collect();

        foreach ($myTinderDogs as $dog) $recomendedDogs = $recomendedDogs->concat($this->getRecommendedDogs($dog));

        $recomendedDogs = $recomendedDogs->unique('id');
        
        return view('tinder.index')->with('dogs', $recomendedDogs)->with('myDogs', $myTinderDogs);
    }

    public function filter(Request $request)
    {
        if (!$request->dog_id) return redirect()->route('tinder.index');

        $myDog = Dog::where('id' , $request->dog_id)->first();

        return view('tinder.index')->with('dogs', $this->getRecommendedDogs($myDog))->with('myDogs', $this->getMyTinderDogs());
    }

    private function getMyTinderDogs()
    {
        return Dog::where('user_id', auth()->user()->id)
            ->where('is_on_tinder', true)
            ->get();
    }

    private function getRecommendedDogs(Dog $myDog) 
    {
        $currentDogYear = $myDog->date_of_birth->format('Y');
        $twoYearsAgo = $currentDogYear - 2;
        $twoYearsLater = $currentDogYear + 2;
        
        return Dog::where('is_on_tinder', true)
            ->where('user_id', '!=', auth()->user()->id)
            ->where('race', $myDog->race)
            ->where('gender', '!=', $myDog->gender)
            ->whereRaw("YEAR(date_of_birth) BETWEEN $twoYearsAgo AND $twoYearsLater")
            ->get();
    }
}
