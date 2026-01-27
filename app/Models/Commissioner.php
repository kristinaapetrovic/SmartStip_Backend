<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commissioner extends Model
{
    /** @use HasFactory<\Database\Factories\CommissionerFactory> */
    use HasFactory;
    protected $guarded = ['commissioner_id'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }   
}
