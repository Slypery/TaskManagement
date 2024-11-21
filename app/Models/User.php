<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;

class User extends Authenticable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'role',
        'password'
    ];
    protected $hidden = [
        'password'
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public static function getUserByUsernameOrEmail($emailOrUsername){
        return self::where('email', $emailOrUsername)->orWhere('username', $emailOrUsername)->first();
    }
}
