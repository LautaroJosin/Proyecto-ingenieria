<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'park_name',
    ];

    public function caregivers()
    {
        return $this->hasMany(Caregiver::class);
    }
}
