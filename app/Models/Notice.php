<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Efiling\CaseFile;


class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'notice_type',
        'hearing_date',
    ];

    // Map notice_type ID to name
    public const NOTICE_TYPES = [
        1 => 'After admission (Form 9)',
        2 => 'Order as per practice',
        3 => 'OA Judgment as per practice',
        4 => 'OA take notice',
        5 => 'Before admission (Form 8)',
        6 => 'After admission as per practice (Old Version)',
    ];

    // Accessor to get notice type name from ID
    public function getNoticeTypeNameAttribute(): string
    {
        return self::NOTICE_TYPES[$this->notice_type] ?? 'Unknown';
    }

    public function case()
    {
        return $this->belongsTo(CaseFile::class, 'case_id');
    }


}
