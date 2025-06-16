<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgeMaster extends Model
{
    use HasFactory;

    protected $table = 'judge_master';

    protected $fillable = [
        'judge_name',
        'desg_id',
        'judge_code',
        'display',
        'from_date',
        'to_date',
        'priority',
        'judge_short_name',
    ];
}
