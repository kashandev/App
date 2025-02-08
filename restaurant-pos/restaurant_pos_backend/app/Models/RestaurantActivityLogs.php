<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantActivityLogs extends Model
{
    use HasFactory;
    protected $fillable = ['activity', 'ip', 'device_name' , 'created_by'];
    public $timestamps = false;
}
