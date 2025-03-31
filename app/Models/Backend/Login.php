<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status'
    ];
}
