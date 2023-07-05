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
        $twoYearsAgo = $myDog->date_of_birth->subYears(2);
        $twoYearsLater = $myDog->date_of_birth->addYears(2);

        return Dog::where('is_on_tinder', true)
            ->where('user_id', '!=', auth()->user()->id)
            ->where('race', $myDog->race)
            ->where('gender', '!=', $myDog->gender)
            ->whereBetween('date_of_birth', [$twoYearsAgo, $twoYearsLater])
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
