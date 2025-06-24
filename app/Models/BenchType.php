<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenchType extends Model
{
    use HasFactory;
    protected $table = 'bench_types';

    protected $fillable = [
        'type_name',
        'short_form',
    ];

     
    public function benchType()
    {
        return $this->belongsTo(BenchType::class, 'bench_type', 'id');
    }
}