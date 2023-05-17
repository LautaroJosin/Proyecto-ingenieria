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

    public function treatments() {
        return $this->hasMany(Treatment::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
