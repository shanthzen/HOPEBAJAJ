<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'details',
        'ip_address'
    ];

    protected $casts = [
        'details' => 'array',
        'created_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the model that was affected by this action.
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model that was affected by this action.
     */
    public function subject()
    {
        return $this->morphTo('model');
    }

    /**
     * Scope a query to only include logs for a specific action.
     */
    public function scopeOfAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to only include logs for a specific model type.
     */
    public function scopeOfModel($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Get a human-readable description of the activity.
     */
    public function getDescriptionAttribute()
    {
        $user = $this->user ? $this->user->name : 'Unknown user';
        $action = ucfirst($this->action);
        $modelType = class_basename($this->model_type);
        
        switch ($this->action) {
            case 'login':
                return "{$user} logged in";
            case 'create':
                return "{$user} created a new {$modelType}";
            case 'update':
                return "{$user} updated a {$modelType}";
            case 'delete':
                return "{$user} deleted a {$modelType}";
            default:
                return "{$user} performed {$action} on {$modelType}";
        }
    }
}
