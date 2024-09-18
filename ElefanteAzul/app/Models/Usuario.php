<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Usuario extends Authenticatable
{
    use HasFactory, HasUuids;

    protected $table = 'usuarios';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username', 'password', 'google_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;
}
