<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reason;
use App\Enums\AppointmentStatesEnum;

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

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function isWaitingForAppointment(Reason $reason): bool
    {
        return $this->appointments()
                ->where('reason_id', '=', $reason->id)
                ->where(function($query) {
                    $query->where('state', '=', AppointmentStatesEnum::PENDING->value)
                        ->orWhere('state', '=', AppointmentStatesEnum::CONFIRMED->value);
                })
                ->exists();
    }

    public function isCastrated(): bool
    {
        return $this->treatments()
                ->where('reason', '=', 'Castración') //El id 4 es el de castración ¡¡HARDCODEADO!!
                ->exists();
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
