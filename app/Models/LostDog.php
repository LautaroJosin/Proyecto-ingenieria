<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostDog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'found',
        'reunited',
        'gender',
        'race',
        'date_of_birth',
        'description',
        'place',
        'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lostRequests()
    {
        return $this->hasMany(LostRequest::class, 'dog_requested', 'id');
    }

    public function ageForHumans()
    {
        return $this->date_of_birth->longAbsoluteDiffForHumans();
    }

    public function wasRequestedBy(int $user_id)
    {
        return LostRequest::where('user_id', $user_id)
            ->where('dog_requested', $this->id)
            ->exists();
    }

    public function wasRequested()
    {
        return LostRequest::where('dog_requested', $this->id)->exists();
    }
}
