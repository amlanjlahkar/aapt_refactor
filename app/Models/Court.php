<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // assuming your courts table has a 'name' column
        'court_no',
    ];

    public function benchCompositions()
    {
        return $this->hasMany(BenchComposition::class, 'court_no');
    }
}
