<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory;
    public static $types = ['kredit', 'stipendija', 'stipendija_nedostajuca_zaimanja'];
    protected $guarded = ['contract_id'];   
    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(ScholarshipCall::class, 'scholarship_call_id', 'id');
    }

    public function scopeWithStudentIndex($query, $index)
    {
        return $query->whereHas('student', fn($q) => $q->where('index_number', $index));
    }
}
