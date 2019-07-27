<?php

namespace App\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user_auth extends Authenticatable implements JWTSubject
{
    protected $table = 'user_auth';
    protected $fillable = ['user_name', 'password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
