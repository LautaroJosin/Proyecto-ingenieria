<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('userDog.index')->with('dogs', User::find(Auth::id())->dogs);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dog $dog)
    {
        return view('userDog.show')->with('dog', $dog);
    }
}

/*
 */