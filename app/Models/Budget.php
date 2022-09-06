<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'budget';
    protected $fillable = [
        'sector_id',
        'year',
        'month',
        'budget',
        'remarks',
    ];

    public function sector(){
        return $this->belongsTo(Sector::class);
    }
}
