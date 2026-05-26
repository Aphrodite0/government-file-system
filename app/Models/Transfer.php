<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'from_office_id',
        'to_office_id',
        'status',
        'sent_at',
        'received_at',
        'read_at',
        'notes',
        'rejection_reason',
        'sent_by',
        'received_by',
        'priority',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'received_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Get the document being transferred
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Get the office sending the document
     */
    public function fromOffice(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'from_office_id');
    }

    /**
     * Get the office receiving the document
     */
    public function toOffice(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'to_office_id');
    }

    /**
     * Get the user who sent the document
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    /**
     * Get the user who received the document
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Mark as sent
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    /**
     * Mark as received
     */
    public function markAsReceived($receivedBy): void
    {
        $this->update([
            'status' => 'received',
            'received_at' => now(),
            'received_by' => $receivedBy,
        ]);
    }

    /**
     * Mark as read
     */
    public function markAsRead(): void
    {
        $this->update([
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    /**
     * Mark as rejected
     */
    public function markAsRejected($reason): void
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }

    /**
     * Check if transfer is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if transfer is sent
     */
    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    /**
     * Check if transfer is received
     */
    public function isReceived(): bool
    {
        return $this->status === 'received';
    }

    /**
     * Check if transfer is read
     */
    public function isRead(): bool
    {
        return $this->status === 'read';
    }

    /**
     * Check if transfer is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Get priority badge color
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'danger',
            'high' => 'warning',
            'normal' => 'info',
            'low' => 'secondary',
            default => 'info',
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'sent' => 'info',
            'received' => 'success',
            'read' => 'secondary',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
