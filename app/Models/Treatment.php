<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'date_of_appointment',
        'reason',
        'weight',
        'vaccine',
        'dewormer', //desparasitante
    ];

    public function dog() {
        return $this->belongsTo(Dog::class, 'dog_id', 'id');
    }
}
