<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;

class DogController extends Controller
{
    public function index() {
        return view('dog.index');
    }

    public function create() {
        return view('dog.create');
    }

    public function store(Request $request) {
        $dog = Dog::create([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'race' => $request->input('race'),
            'description' => $request->input('description'),
            'date_of_birth' => $request->input('date_of_birth'),
            'photo' => "debería_ir_una_url",
        ]);
        return $dog;
    }

    public function destroy($id) {
    }

    public function showHealthBook($id) {
    }
}
