<?php

namespace App\Models\Internal\Purpose;

use Illuminate\Database\Eloquent\Model;

class PurposeMaster extends Model {
    protected $table = 'purpose_master';

    protected $fillable = [
        'purpose_name',
    ];
}
