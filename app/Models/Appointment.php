<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'state',
        'date',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function reason() {
        return $this->belongsTo(Reason::class, 'reason_id', 'id');
    }

    public function dogs() {
        return $this->belongsTo(Dog::class, 'dog_id', 'id');
    }
}
