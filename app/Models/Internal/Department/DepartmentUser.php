<?php

namespace App\Models\Internal\Department;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Spatie\Permission\Traits\HasRoles;

class DepartmentUser extends Authenticable {
    /** @use HasFactory<\Database\Factories\Internal\DepartmentUserFactory> */
    use HasFactory, HasRoles;

    protected $guard = 'dept_user';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
