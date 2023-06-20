<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCampaign extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'name',
        'start_date',
        'end_date',
        'description',
        'photo',
        'current_fundraised',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
