<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    const TABLE = 'users';
    const ID = self::TABLE . '.id';
    const NAME = self::TABLE . '.name';
    const EMAIL = self::TABLE . '.email';

    protected $table = self::TABLE;

    protected $fillable = [
        'name', 'password', 'email', 'template',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
