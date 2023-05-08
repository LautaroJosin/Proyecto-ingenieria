<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'name',
        'gender',
        'race',
        'date_of_birth',
        'description',
        'photo',
    ];
}
