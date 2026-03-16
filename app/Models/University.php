<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    /** @use HasFactory<\Database\Factories\UniversityFactory> */
    use HasFactory;

    protected $guarded = ['university_id']; 

    public function faculties():HasMany
    {
        return $this->hasMany(Faculty::class);
    }

    public function location():BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function scopeWithName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', "%$name%");
        }
        return $query;
    }

    public function scopeWithLocation($query, $locationId)
    {
        if ($locationId) {
            return $query->where('location_id', $locationId);
        }
        return $query;
    }
}
