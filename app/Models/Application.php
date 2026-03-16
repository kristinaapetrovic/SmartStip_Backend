<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ScholarshipCall;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;
    public static array $statuses = ['pending', 'on assessment', 'documents valid', 'approved', 'rejected'];
    protected $guarded = ['id'];
    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function scholarship():BelongsTo
    {
        return $this->belongsTo(ScholarshipCall::class, 'scholarship_call_id', 'id');
    }

    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function scopeForAdminFaculty($query, $user)
    {
        if ($user && $user->administrator) {
            $facultyId = $user->administrator->faculty_id;

            return $query->whereHas('student', function ($q) use ($facultyId) {
                $q->where('faculty_id', $facultyId);
            });
        }

        return $query;
    }
}