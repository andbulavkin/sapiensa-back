<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = [
        'profile_url',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'growUnit',
        'electricalConductivity',
        'flower',
        'clone',
        'mother',
        'vegitative',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!is_null($user->password)) {
                $user->password = bcrypt($user->password);
            }
        });
    }

    public function getProfileUrlAttribute()
    {
        $url = asset('images/profile.svg');
        if ($this->profile != null) {
            $url = asset('storage/' . $this->profile);
        }
        return $url;
    }
}
