<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait HasActivityLogs
{
    protected static function bootHasActivityLogs()
    {
        // Log model creation
        static::created(function ($model) {
            $model->logActivity('create', [
                'attributes' => $model->getAttributes()
            ]);
        });

        // Log model updates
        static::updated(function ($model) {
            $model->logActivity('update', [
                'changed' => $model->getDirty(),
                'original' => $model->getOriginal()
            ]);
        });

        // Log model deletion
        static::deleted(function ($model) {
            $model->logActivity('delete', [
                'deleted_model' => [
                    'id' => $model->id,
                    'attributes' => $model->getAttributes(),
                    'relations' => $model->getRelations()
                ]
            ]);
        });
    }

    /**
     * Get all activity logs for this model.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'model');
    }

    /**
     * Log an activity for this model.
     */
    public function logActivity($action, $details = null)
    {
        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'details' => $details,
            'ip_address' => request()->ip()
        ]);
    }

    /**
     * Get the latest activity for this model.
     */
    public function getLatestActivityAttribute()
    {
        return $this->activityLogs()->latest()->first();
    }

    /**
     * Get activities of a specific type for this model.
     */
    public function getActivitiesByType($type)
    {
        return $this->activityLogs()->where('action', $type)->get();
    }
}
