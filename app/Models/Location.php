<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'city',
        'country',
        'country_code',
        'capital',
        'longitude',
        'latitude',
        'flag',
        'weather_name',
        'temperature',
        'humidity',
        'weather_image',
        'time',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }
}
