<?php

namespace App\Models\Internal\Department;

use Illuminate\Database\Eloquent\Model;

class DepartmentMaster extends Model {
    protected $table = 'department_master';

    protected $fillable = [
        'dept_name',
    ];
}
