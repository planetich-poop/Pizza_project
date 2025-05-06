<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'phone', 'address'];

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // JWT Methods
    public function getJWTIdentifier()
    {
        return $this->getKey(); // обычно это ID пользователя
    }

    public function getJWTCustomClaims()
    {
        return []; // сюда можно добавить кастомные поля, если нужно
    }
}
