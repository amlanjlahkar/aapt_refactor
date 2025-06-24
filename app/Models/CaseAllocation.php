<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Efiling\CaseFile;
use App\Models\Internal\Purpose\PurposeMaster;

class CaseAllocation extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'Draft';
    const STATUS_PREPARED = 'Prepared'; 
    const STATUS_PUBLISHED = 'Published';

    protected $table = 'case_allocations';

    protected $fillable = [
        'case_file_id',
        'serial_no',
        'item_no',
        'causelist_date',
        'causelist_type',
        'purpose_id',
        'purpose', 
        'entry_date',
        'user_id',
        'priority',
        'remarks',
        'listing_criteria',
        'bench_id',
        'status',
        'published_by',
        'published_at',
    ];

    protected $casts = [
        'causelist_date' => 'date',
        'entry_date' => 'date',
        'published_at' => 'datetime',
        'priority' => 'float',
    ];

    public function caseFile()
    {
        return $this->belongsTo(CaseFile::class);
    }

    public function purpose()
    {
        return $this->belongsTo(PurposeMaster::class, 'purpose_id');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class);
    }

    public function bench()
    {
        return $this->belongsTo(BenchComposition::class);
    }

    public function publishedBy()
    {
        return $this->belongsTo(Admin::class, 'published_by');
    }

    public function getIsPreparedAttribute()
    {
        return $this->status === 'prepared';
    }

    public function getIsPublishedAttribute()
    {
        return $this->status === 'published';
    }

    // helper methods
    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PREPARED,
            self::STATUS_PUBLISHED
        ];
    }

    public function isPrepared()
    {
        return $this->status === self::STATUS_PREPARED;
    }

    public function isPublished()
    {
        return $this->status === self::STATUS_PUBLISHED;
    }
}