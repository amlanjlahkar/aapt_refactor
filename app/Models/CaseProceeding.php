<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseProceeding extends Model
{
    use HasFactory;

    protected $table = 'case_proceedings';

    protected $fillable = [
        'case_file_id',
        'purpose_id',
        'purpose_text',
        'bench_id',
        'bench_nature',
        'court_no',
        'listing_date',
        'next_purpose',
        'next_criteria',
        'next_date',
        'todays_action',
        'todays_status',
        'entry_date',
        'remarks',
        'user_id',
        'job_status',
        'party_type',
        'adjournment',
        'party_filed',
        'ialist',
    ];

    // Relationships
    public function caseFile()
    {
        return $this->belongsTo(CaseFile::class, 'case_file_id');
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'purpose_id');
    }

    public function bench()
    {
        return $this->belongsTo(BenchComposition::class, 'bench_id');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
