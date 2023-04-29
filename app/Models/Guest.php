<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'visits',
        'ip',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Location::class, 'guest_id');
    }
}
