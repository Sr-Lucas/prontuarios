<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $guard = 'user';

    protected $fillable = [
        'cpf',
        'user_type',
        'password',
        'is_deleted',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'is_deleted',
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function administrator()
    {
        return $this->hasOne(Administrator::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'user_id' => $this->id,
            'user_type' => $this->user_type,
        ];
    }
}
