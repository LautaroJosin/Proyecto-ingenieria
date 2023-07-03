<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;

class TinderController extends Controller
{
    public function index()
    {
        $myTinderDogs = $this->getMyTinderDogs();

        $recommendedDogs = collect();

        foreach ($myTinderDogs as $dog) $recommendedDogs = $recommendedDogs->concat($this->getOwnerDogNames($dog));

        $recommendedDogs = $recommendedDogs->groupBy('id');

        return view('tinder.index')
            ->with('dogs', $recommendedDogs)
            ->with('myDogs', $myTinderDogs);
    }


    public function filter(Request $request)
    {
        if (!$request->dog_id) return redirect()->route('tinder.index');

        $myDog = Dog::where('id', $request->dog_id)->first();

        $recommendedDogs = $this->getOwnerDogNames($myDog);

        $recommendedDogs = $recommendedDogs->groupBy('id');

        return view('tinder.index')
            ->with('dogs', $recommendedDogs)
            ->with('myDogs', $this->getMyTinderDogs());
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

    private function getOwnerDogNames (Dog $dog)
    {
        return $this->getRecommendedDogs($dog)->map(function ($recommendedDog) use ($dog) {
            $recommendedDog->ownerDogNames = [$dog->name];
            return $recommendedDog;
        });
    }
}
