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

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];

    public function treatments() {
        return $this->hasMany(Treatment::class);
    }

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
