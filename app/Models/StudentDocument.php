<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\EnrolledStudent;
use App\Models\User;

class StudentDocument extends Model
{
    protected $fillable = [
        'student_id',
        'document_type',
        'document_name',
        'file_path',
        'file_type',
        'file_size',
        'verification_status',
        'verification_notes',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Document types
    public const DOCUMENT_TYPES = [
        'id_proof' => 'ID Proof',
        'photo' => 'Photograph',
        'certificate' => 'Certificate',
        'marksheet' => 'Mark Sheet',
        'resume' => 'Resume',
        'other' => 'Other'
    ];

    // Verification statuses
    public const VERIFICATION_STATUSES = [
        'pending' => 'Pending',
        'verified' => 'Verified',
        'rejected' => 'Rejected'
    ];

    // Relationship with student
    public function student(): BelongsTo
    {
        return $this->belongsTo(EnrolledStudent::class, 'student_id');
    }

    // Relationship with verifier
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Get human-readable document type
    public function getDocumentTypeTextAttribute(): string
    {
        return self::DOCUMENT_TYPES[$this->document_type] ?? $this->document_type;
    }

    // Get human-readable verification status
    public function getVerificationStatusTextAttribute(): string
    {
        return self::VERIFICATION_STATUSES[$this->verification_status] ?? $this->verification_status;
    }

    // Get formatted file size
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Verify document
    public function verify(User $user, string $notes = null): bool
    {
        return $this->update([
            'verification_status' => 'verified',
            'verification_notes' => $notes,
            'verified_at' => now(),
            'verified_by' => $user->id
        ]);
    }

    // Reject document
    public function reject(User $user, string $notes): bool
    {
        return $this->update([
            'verification_status' => 'rejected',
            'verification_notes' => $notes,
            'verified_at' => now(),
            'verified_by' => $user->id
        ]);
    }
}
