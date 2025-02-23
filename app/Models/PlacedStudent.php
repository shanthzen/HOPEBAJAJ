<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasActivityLogs;

class PlacedStudent extends Model
{
    use HasFactory, SoftDeletes, HasActivityLogs;

    protected $fillable = [
        'graduate_id',
        'batch_no',
        'name',
        'phone_number',
        'company_name',
        'designation',
        'salary',
        'joining_date',
        'supporting_documents'
    ];

    protected $dates = [
        'joining_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2',
        'graduate_id' => 'integer'
    ];

    // Accessors
    public function getBatchNoAttribute($value)
    {
        return $value ?? '';
    }

    public function getSupportingDocumentsAttribute($value)
    {
        if (!$value) {
            return null;
        }
        
        // Check if the file exists in storage
        if (!Storage::disk('public')->exists($value)) {
            return null;
        }
        
        return Storage::url($value);
    }

    // Mutators
    public function setBatchNoAttribute($value)
    {
        $this->attributes['batch_no'] = $value ?? '';
    }

    public function setSalaryAttribute($value)
    {
        if (is_string($value)) {
            $value = preg_replace('/[^0-9.]/', '', trim($value));
        }
        $this->attributes['salary'] = floatval($value);
    }

    public function getRawSalaryAttribute()
    {
        return floatval($this->attributes['salary']) / 100000;
    }

    public function getSalaryAttribute($value)
    {
        return number_format($this->raw_salary, 2) . ' LPA';
    }

    public function setJoiningDateAttribute($value)
    {
        if ($value) {
            $this->attributes['joining_date'] = date('Y-m-d', strtotime($value));
        }
    }

    public function setSupportingDocumentsAttribute($value)
    {
        if ($value && $value->isValid()) {
            // Delete old file if exists
            if (isset($this->attributes['supporting_documents'])) {
                Storage::disk('public')->delete($this->attributes['supporting_documents']);
            }
            $this->attributes['supporting_documents'] = $value->store('placements/documents', 'public');
        }
    }

    public function graduate()
    {
        return $this->belongsTo(Graduate::class)->withDefault();
    }
}
