<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = [
        'sector_id',
        'date',
        'time',
        'title',
        'description',
        'amount',
    ];
    
    public function sector(){
        return $this->belongsTo(Sector::class);
    }
}
