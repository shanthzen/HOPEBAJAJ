<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasActivityLogs;

class Graduate extends Model
{
    use HasFactory, SoftDeletes, HasActivityLogs;

    protected $fillable = [
        'batch_no',
        'certificate_no',
        'name',
        'phone_number',
        'course_name',
        'course_duration',
        'start_date',
        'end_date',
        'total_days_attended',
        'id_proof_type',
        'id_proof_number',
        'aadhar_number',
        'certificate_path'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_days_attended' => 'integer'
    ];

    public function student()
    {
        return $this->belongsTo(EnrolledStudent::class, 'student_id');
    }

    public function placement()
    {
        return $this->hasOne(PlacedStudent::class);
    }
}
