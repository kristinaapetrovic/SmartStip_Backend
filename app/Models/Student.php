<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    public static $types_of_study = ['undergraduate', 'graduate', 'postgraduate'];
    protected $guarded = ['student_id'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function faculty():BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function location():BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function contract():HasOne
    {
        return $this->hasOne(Contract::class);
    }   

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
