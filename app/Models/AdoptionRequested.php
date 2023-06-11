<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionRequested extends Model
{
    use HasFactory;

    public $timestamps = false;

	protected $fillable=[
        'user_id',
        'guest_email',
        'dog_requested',
    ];
}
