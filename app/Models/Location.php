<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;

    protected $guarded = ['location_id'];

    public function faculties():HasMany
    {
        return $this->hasMany(Faculty::class);
    }

    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }

    

}
