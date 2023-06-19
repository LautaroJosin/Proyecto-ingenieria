<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'card_type',
        'cardholder',
        'card_number',
        'cvv',
        'expiration_date',
        'balance',

    ];

    protected $casts = [
        'expiration_date' => 'date:Y-m-d',
    ];

}
