<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginSession extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'user_type', 'user_name', 'session_start' , 'session_end', 'status'];
    protected $table = 'login_session'; // table name in your database
    protected $primaryKey = 'session_id'; // Replace 'session_id' with your primary key column
    public $timestamps = false;
}
