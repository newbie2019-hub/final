<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
 
class Admin extends Model implements JWTSubject
{
    use HasFactory;
    protected $fillable = [];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
