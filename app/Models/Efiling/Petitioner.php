<?php

namespace App\Models\Efiling;

use Illuminate\Database\Eloquent\Model;

class Petitioner extends Model {
    protected $fillable = [
        'case_file_id',
        'pet_type',

        // Common fields
        'pet_email',
        'pet_mobile',
        'pet_address',

        // Fields for individual petitioner
        'pet_name',
        'pet_age',
        'pet_state',
        'pet_district',

        // Fields for organizational petitioner
        'pet_ministry',
        'pet_department',
        'pet_contact_person',
        'pet_designation',
    ];

    protected $casts = [
        'pet_age' => 'integer',
    ];

    // Relationship: Petitioner belongs to a Case File
    public function caseFile() {
        return $this->belongsTo(CaseFile::class);
    }
}
