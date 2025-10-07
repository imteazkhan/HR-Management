<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageRead extends Model
{
    protected $fillable = [
        'team_message_id',
        'user_id',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    /**
     * Get the message
     */
    public function teamMessage(): BelongsTo
    {
        return $this->belongsTo(TeamMessage::class);
    }

    /**
     * Get the user who read the message
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
