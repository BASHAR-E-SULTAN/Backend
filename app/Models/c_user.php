<?php

namespace App\Models;

use Database\Factories\CUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class c_user extends Model
{
    use HasFactory;

    protected $table = 'user';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_banned',
        'ban_reason',
        'banned_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_banned' => 'boolean',
    ];

    protected static function newFactory(): Factory
    {
        return CUserFactory::new();
    }
}