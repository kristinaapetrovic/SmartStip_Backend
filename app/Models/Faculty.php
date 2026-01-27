<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    /** @use HasFactory<\Database\Factories\FacultyFactory> */
    use HasFactory;
    protected $guarded = ['faculty_id'];
    public function university():BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function location():BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function administrators():HasMany
    {
        return $this->hasMany(Administrator::class);
    }
    
}
