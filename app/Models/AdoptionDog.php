<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AdoptionDog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        'gender',
        'race',
        'date_of_birth',
        'size',
        'description',
    ];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];
	
	
	public function ageForHumans() {
        return $this->date_of_birth->longAbsoluteDiffForHumans();
    }
	
	public function showSize() {
		
		switch ($this->size) {
				
				case 'P' :
					return 'Pequeño';
					break;
				case 'M' :
					return 'Mediano';
					break;
				case 'G' :
					return 'Grande';
					break;
		
		}
    }
	
	public function publisher() {
		$user = User::where('id', $this->user_id)->first();
		return $user->name;
    }
	
	
	
   
}
