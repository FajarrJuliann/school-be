<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class RefUser extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'ref_users'; // Gunakan tabel ref_users

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_login',
        'is_delete',
    ];

    protected $hidden = [
        'password',
    ];
}
