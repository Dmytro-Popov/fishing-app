<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FishCatch extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'catches';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'date',
        'location',
        'tackle',
        'bait',
        'species',
        'weight',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'weight' => 'decimal:2',
    ];
}
