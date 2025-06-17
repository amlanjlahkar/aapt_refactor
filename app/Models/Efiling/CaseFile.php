<?php

namespace App\Models\Efiling;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseFile extends Model {
    protected $fillable = [
        'case_type',
        'bench',
        'subject',
        'legal_aid',
        'filed_by',
        'filing_number',
        'filing_date',
        'step',
        'status',
        'scrutiny_status',
        'reg_number',
        'reg_date',
        'reg_year',
        'date_of_disposal',
        'user_id',
    ];

    protected $casts = [
        'filing_date' => 'date',
        'legal_aid' => 'boolean',
        'reg_date' => 'date',
        'date_of_disposal' => 'date',
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

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function ownedBy($query, $userId) {
        return $query->where('user_id', $userId);
    }
}
