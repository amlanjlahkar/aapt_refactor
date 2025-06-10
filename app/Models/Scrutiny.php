<?php

namespace App\Models;

use App\Models\Objection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scrutiny extends Model
{
    use HasFactory;
    protected $table = 'scrutiny';

    protected $fillable = [
        'case_file_id',
        'filing_number',
        'objection_status',
        'other_objection',
        'scrutiny_status',
        'scrutiny_date',
        'communication_date',
        'compliance_date',
        'completion_date',
        'user_id',
        'level',
        'remarks_registry',
        'remarks_section_officer',
        'remarks_dept_head',
    ];

    public function caseFile()
    {
        return $this->belongsTo(CaseFile::class);
    }

    public function getLevelNameAttribute()
    {
        return match ($this->level) {
            1 => 'Registry Reviewer',
            2 => 'Section Officer',
            3 => 'Department Head',
            default => 'Unknown',
        };
    }

    public static function levelNames()
    {
        return [
            1 => 'Registry Reviewer',
            2 => 'Section Officer',
            3 => 'Department Head',
        ];
    }


}
