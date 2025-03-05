<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GraduatedStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'course_name',
        'batch_no',
        'graduation_date',
        'grade',
        'status'
    ];

    protected $dates = [
        'graduation_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
