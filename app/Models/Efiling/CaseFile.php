<?php

namespace App\Models\Efiling;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseFile extends Model {
    protected $fillable = [
        'case_type',
        'bench',
        'subject',
        'legal_aid',
        'filed_by',
        'ref_number',
        'filing_number',
        'filing_date',
        'step',
        'status',
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

    public function scrutinies()
    {
        return $this->hasMany(\App\Models\Scrutiny::class, 'case_file_id');
    }

    public function latestScrutiny()
    {
        return $this->hasOne(\App\Models\Scrutiny::class)->latestOfMany();
    }


}
