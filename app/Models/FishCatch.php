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
        'user_id',
        'date',
        'location',
        'tackle',
        'bait',
        'species',
        'photo',
        'weight',
        'temperature',
        'weather_condition',
        'wind_speed',
        'pressure',
        'humidity',
        'weather_source',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'weight' => 'decimal:2',
        'temperature' => 'decimal:1',
        'wind_speed' => 'decimal:1',
        'pressure' => 'integer',
        'humidity' => 'integer',
    ];

    public function user()
    {
        // Улов принадлежит одному пользователю
        return $this->belongsTo(User::class);
    }
}
