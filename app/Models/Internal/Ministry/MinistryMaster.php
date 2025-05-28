<?php

namespace App\Models\Internal\Ministry;

use Illuminate\Database\Eloquent\Model;

class MinistryMaster extends Model {
    protected $table = 'ministry_master';

    protected $fillable = [
        'ministry_name',
        'short_form',
    ];
}
