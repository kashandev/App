<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantLoginActivity extends Model
{
    use HasFactory;
    protected $fillable = ['login_by', 'ip', 'device_name' , 'status'];
    protected $table = 'restaurant_login_activity'; // table name in your database
    protected $primaryKey = 'login_activity_id'; // Replace 'id' with your primary key column
    public $timestamps = false;
}
