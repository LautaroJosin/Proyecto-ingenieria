<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use Illuminate\Support\Facades\DB;

class DogController extends Controller
{
    public function index() {
        return view('dog.index', ['dogs' => DB::table('dogs')->get()]);
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
        return $dog; //dog::create($request->all())
    }

    public function destroy($id) {
        $deletedDog = DB::table('dogs')->where('id', '=', $id)->delete();
        return view('dog.index', ['dogs' => DB::table('dogs')->get()]);
    }

    public function showHealthBook($id) {
    }
}
