<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagerSetting extends Model
{
    protected $fillable = [
        'user_id',
        'email_notifications',
        'push_notifications',
        'weekly_reports',
        'auto_approve_leaves',
        'team_size_limit',
        'notification_preferences'
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'weekly_reports' => 'boolean',
        'auto_approve_leaves' => 'boolean',
        'notification_preferences' => 'array'
    ];

    /**
     * Get the user that owns the settings
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get or create settings for a user
     */
    public static function getOrCreateForUser($userId)
    {
        return static::firstOrCreate(
            ['user_id' => $userId],
            [
                'email_notifications' => true,
                'push_notifications' => false,
                'weekly_reports' => true,
                'auto_approve_leaves' => false,
                'team_size_limit' => 20
            ]
        );
    }
}
