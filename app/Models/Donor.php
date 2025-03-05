<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Donor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'description',
        'contributions',
        'impact',
        'contact_email',
        'contact_phone',
        'website'
    ];

    protected $appends = ['logo_url'];

    // Accessor for logo URL
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        return Storage::url('donors/' . $this->logo);
    }

    // Format phone number
    public function getContactPhoneAttribute($value)
    {
        if (!$value) {
            return null;
        }
        // Format: +91 XXXXX XXXXX
        return '+91 ' . substr($value, 0, 5) . ' ' . substr($value, 5);
    }

    // Format website URL
    public function getWebsiteAttribute($value)
    {
        if (!$value) {
            return null;
        }
        if (!str_starts_with($value, 'http')) {
            return 'https://' . $value;
        }
        return $value;
    }
}
