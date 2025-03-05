<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Placement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sl_no',
        'batch_no',
        'name',
        'phone_number',
        'company_name',
        'designation',
        'salary',
        'supporting_documents'
    ];

    protected $casts = [
        'salary' => 'decimal:2'
    ];

    public function getStudentNameAttribute()
    {
        return $this->name;
    }
}
