<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administrator extends Model
{
    /** @use HasFactory<\Database\Factories\AdministratorFactory> */
    use HasFactory;

    protected $guarded = ['administrator_id'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function faculty():BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    
}
