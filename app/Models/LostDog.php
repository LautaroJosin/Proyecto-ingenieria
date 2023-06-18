<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostDog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'name', //y vamo a ver qué dice Tadeo
        'type',
        'found',
        'reunited',
        'gender',
        'race',
        'date_of_birth',
        'description',
        'place',
        'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function ageForHumans() {
        return $this->date_of_birth->longAbsoluteDiffForHumans();
    }

    public function ageInYears() {
        return $this->date_of_birth->diffInYears();
    }

    public function ageInMonths() {
        return $this->date_of_birth->diffInMonths();
    }
 
    public function ageInDays() {
        return $this->date_of_birth->diffInDays();
    }
}
