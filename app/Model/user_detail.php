<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class user_detail extends Model
{
    protected $table='users';
    protected $fillable = ['name','user_name','dob','gender','slack_id','gmail_id','contact'];
}
