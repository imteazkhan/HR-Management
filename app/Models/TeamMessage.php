<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMessage extends Model
{
    protected $fillable = [
        'sender_id',
        'subject',
        'message',
        'priority',
        'recipients',
        'is_announcement',
        'sent_at'
    ];

    protected $casts = [
        'recipients' => 'array',
        'is_announcement' => 'boolean',
        'sent_at' => 'datetime'
    ];

    /**
     * Get the sender of the message
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Scope for messages sent by a specific user
     */
    public function scopeBySender($query, $senderId)
    {
        return $query->where('sender_id', $senderId);
    }

    /**
     * Scope for messages sent to a specific user
     */
    public function scopeForRecipient($query, $userId)
    {
        return $query->whereJsonContains('recipients', $userId);
    }

    /**
     * Scope for announcements
     */
    public function scopeAnnouncements($query)
    {
        return $query->where('is_announcement', true);
    }
}
