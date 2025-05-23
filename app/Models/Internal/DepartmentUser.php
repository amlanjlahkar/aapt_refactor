<?php

namespace App\Models\Internal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class DepartmentUser extends Model {
    use HasFactory, HasRoles;

    protected $guard_name = 'department';

    protected $fillable = [
        'name',
        'email',
        'department',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
