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
}
