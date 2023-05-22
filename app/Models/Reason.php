<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'reason',
        'price',
    ];

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
}
