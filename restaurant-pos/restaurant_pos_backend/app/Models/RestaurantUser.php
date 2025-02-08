<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject; // Import the interface
use Illuminate\Database\Eloquent\Model;

class RestaurantUser extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = ['user_type', 'user_name', 'login_name' , 'email', 'password_hash'];
    protected $table = 'restaurant_user'; // Replace 'users' with the actual table name in your database
    protected $primaryKey = 'user_id'; // Replace 'user_id' with your primary key column
    // Disable automatic timestamp management
    public $timestamps = false;
    // ... other model configurations ...

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
