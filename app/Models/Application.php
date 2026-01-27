<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;
    public static array $statuses = ['pending', 'approved', 'rejected'];
    protected $guarded = ['application_id'];
    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function scholarship():BelongsTo
    {
        return $this->belongsTo(ScholarshipCall::class);
    }

}
