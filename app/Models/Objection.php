<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_file_id',
        'filing_number',
        'objection_code',
        'status',
        'remarks',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function caseFile()
    {
        return $this->belongsTo(CaseFile::class, 'filing_number', 'filing_number');
    }
}