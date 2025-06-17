<?php

namespace App\Models\Efiling;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseDocument extends Model {
    protected $fillable = [
        'case_file_id',
        'document',
        'document_type',
        'mimetype',
        'original_name',
    ];

    protected $casts = [
        //
    ];

    // Relationship: Document belongs to a Case File
    public function caseFile(): BelongsTo {
        return $this->belongsTo(CaseFile::class, 'case_file_id');
    }
}
