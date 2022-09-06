<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'sector_id',
        'date',
        'time',
        'title',
        'description',
        'min_amount',
        'max_amount',
    ];

    public function sector(){
        return $this->belongsTo(Sector::class);
    }
}
