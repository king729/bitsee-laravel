<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function findForPassport($username)
    {
        $user = $this->orWhere('email', $username)->orWhere('mobile', $username)->first();
        return $user;
    }

    /*第一方应用不再通过密码认证*/
    public function validateForPassportPasswordGrant($password)
    {
        return true;
    }
}
