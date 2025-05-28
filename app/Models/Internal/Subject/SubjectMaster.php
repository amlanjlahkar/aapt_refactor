<?php

namespace App\Models\Internal\Subject;

use Illuminate\Database\Eloquent\Model;

class SubjectMaster extends Model {
    protected $table = 'subject_master';

    protected $fillable = [
        'subject_name',
    ];
}
