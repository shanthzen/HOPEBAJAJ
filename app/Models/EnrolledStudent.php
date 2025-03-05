<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Traits\HasActivityLogs;

class EnrolledStudent extends Model
{
    use HasFactory, SoftDeletes, HasActivityLogs;

    protected $fillable = [
        'batch_no',
        'batch_timings',
        'faculty_name',
        'full_name',
        'email',
        'student_user_id',
        'user_credential',
        'id_proof_type',
        'id_proof_number',
        'date_of_birth',
        'contact_number',
        'whatsapp_number',
        'gender',
        'qualification',
        'college_name',
        'college_address',
        'is_pursuing',
        'looking_for_job',
        'student_photo',
        'student_signature',
        'name',
        'enrollment_date',
        'course_enrolled',
        'status'
    ];

    protected $dates = [
        'date_of_birth',
        'enrollment_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'is_pursuing' => 'boolean',
        'looking_for_job' => 'boolean',
        'date_of_birth' => 'date',
        'enrollment_date' => 'date'
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_credential', 'id');
    }
}
