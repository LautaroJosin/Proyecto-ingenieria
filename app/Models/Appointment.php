<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatesEnum;

class Appointment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'state',
        'date',
    ];

    protected $casts = [
        'state' => AppointmentStatesEnum::class,
        'date' => 'date:Y-m-d',
        'time' => 'datetime',
    ];

    public function reason() {
        return $this->belongsTo(Reason::class, 'reason_id', 'id');
    }

    public function dog() {
        return $this->belongsTo(Dog::class, 'dog_id', 'id');
    }
}
