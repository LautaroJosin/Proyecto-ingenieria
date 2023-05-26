<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionDog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'gender',
        'race',
        'date_of_birth',
        'description',
    ];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];
}
