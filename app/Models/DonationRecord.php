<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRecord extends Model
{
    use HasFactory;


    protected $fillable=[
        'campaign_id',
        'donation_time',
        'donation_date',
        'amount',
        'user_id',
        'was_registered',
    ];
}
