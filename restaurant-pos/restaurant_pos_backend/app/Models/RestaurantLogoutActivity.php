<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantLogoutActivity extends Model
{
    use HasFactory;
    protected $fillable = ['logout_by', 'ip', 'device_name' , 'status'];
    protected $table = 'restaurant_logout_activity'; // table name in your database
    protected $primaryKey = 'logout_activity_id'; // Replace 'id' with your primary key column
    public $timestamps = false;
}
