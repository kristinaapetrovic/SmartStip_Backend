<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipCall extends Model
{
    /** @use HasFactory<\Database\Factories\ScholarshipCallFactory> */
    use HasFactory;
    public static $statuses = ['open', 'closed'];
    protected $guarded = ['scholarship_call_id'];
}
