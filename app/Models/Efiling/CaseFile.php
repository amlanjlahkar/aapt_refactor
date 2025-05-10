<?php

namespace App\Models\Efiling;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseFile extends Model {
    protected $fillable = [
        'bench',
        'case_type',
        'filed_by',
        'filing_date',
        'filing_no',
        'filing_number',
        'legal_aid',
        'status',
        'step',
        'subject',
    ];

    protected $casts = [
        'filing_date' => 'date',
        'legal_aid' => 'boolean',
    ];

    public function petitioners(): HasMany {
        return $this->hasMany(Petitioner::class);
    }

    public function respondents(): HasMany {
        return $this->hasMany(Respondent::class);
    }

    public function documents(): HasMany {
        return $this->hasMany(CaseDocument::class);
    }

    public function payment(): HasMany {
        return $this->hasMany(CasePayment::class);
    }
}
