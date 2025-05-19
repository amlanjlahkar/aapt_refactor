<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
<<<<<<< HEAD

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    protected $hidden = ['password'];
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable {
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
>>>>>>> 80c7f37 (feat: Initial admin logic)
}
