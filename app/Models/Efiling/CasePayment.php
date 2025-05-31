<?php

namespace App\Models\Efiling;

use Illuminate\Database\Eloquent\Model;

class CasePayment extends Model {
    protected $fillable = [
        'case_file_id',
        'payment_mode',
        'amount',
        'ref_no',
        'ref_date',
        'transaction_id',
        'payment_receipt',
    ];

    protected $casts = [
        'ref_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function case() {
        return $this->belongsTo(CaseFile::class, 'case_file_id');
    }
}
