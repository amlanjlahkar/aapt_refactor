<?php

namespace App\Models\Efiling;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model {
    protected $fillable = [
        'case_file_id',
        'res_type',

        // Common fields
        'res_email',
        'res_phone',
        'res_address',

        // Fields for individual respondents
        'res_name',
        'res_age',
        'res_state',
        'res_district',

        // Fields for organizational respondents
        'res_ministry',
        'res_department',
        'res_contact_person',
        'res_designation',
    ];

    protected $casts = [
        'res_age' => 'integer',
    ];

    // Relationship: Respondent belongs to a Case File
    public function caseFile() {
        return $this->belongsTo(CaseFile::class);
    }
}
