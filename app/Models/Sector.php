<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function budgets(){
        return $this->hasMany(Budget::class);
    }

    public function entries(){
        return $this->hasMany(Entry::class);
    }
}
