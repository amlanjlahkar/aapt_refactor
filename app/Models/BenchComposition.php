<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenchComposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_no',
        'judge_id',
        'bench_type',
        'from_date',
        'to_date',
        'display',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class, 'court_no');
    }

    public function judge()
    {
        return $this->belongsTo(JudgeMaster::class, 'judge_id');
    }

    public function benchType()
    {
        return $this->belongsTo(BenchType::class, 'bench_type');
    }
}
