<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMessage extends Model
{
    use HasFactory;
    protected $fillable = ['message_type'];
    protected $table = 'restaurant_message'; // table name in your database
    protected $primaryKey = 'message_id'; // Replace 'id' with your primary key column
    public $timestamps = false;
}
