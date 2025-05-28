<?php

namespace App\Models\Internal\Designation;

use Illuminate\Database\Eloquent\Model;

class DesignationMaster extends Model {
    protected $table = 'designation_master';

    protected $fillable = [
        'designation_name',
        'short_form',
    ];
}
