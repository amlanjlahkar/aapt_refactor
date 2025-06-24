<?php

namespace App\Models\Efiling;

use App\Models\Scrutiny;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Efiling\Petitioner;
use App\Models\Efiling\Respondent;


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
        'case_reg_no',
        'case_reg_year',
        'date_of_registration',
        'case_status',

    ];

    protected $casts = [
        'filing_date' => 'date',
        'legal_aid' => 'boolean',
    ];

    public function petitioners(): HasMany {
    return $this->hasMany(Petitioner::class, 'case_file_id');
    }

    public function respondents(): HasMany {
        return $this->hasMany(Respondent::class, 'case_file_id');
    }
    public function documents(): HasMany {
        return $this->hasMany(CaseDocument::class);
    }

    public function payment(): HasMany {
        return $this->hasMany(CasePayment::class);
    }

    public function scrutiny()
    {
        return $this->hasOne(Scrutiny::class);
    }

    public function latestScrutiny()
    {
        return $this->hasOne(Scrutiny::class, 'case_file_id')->orderByDesc('id');
    }


    public function scrutinies()
    {
        return $this->hasMany(Scrutiny::class, 'case_file_id');
    }

    public function completedScrutiny()
    {
        return $this->hasOne(Scrutiny::class)->where('scrutiny_status', 'Completed');
    }

    public function getPartyNameAttribute()
    {
        $petitionerNames = $this->petitioners->pluck('pet_name')->filter()->join(', ');
        $respondentNames = $this->respondents->pluck('res_name')->filter()->join(', ');
    
        if ($petitionerNames && $respondentNames) {
            return $petitionerNames . ' vs ' . $respondentNames;
        } elseif ($petitionerNames) {
            return $petitionerNames . ' vs [Respondent]';
        } elseif ($respondentNames) {
            return '[Petitioner] vs ' . $respondentNames;
        }
    
        return 'ABC vs XYZ';
    }


}
