<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'office_id',
        'phone',
        'position',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get the office this user belongs to
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Get documents created by this user
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'created_by');
    }

    /**
     * Get transfers sent by this user
     */
    public function sentTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'sent_by');
    }

    /**
     * Get transfers received by this user
     */
    public function receivedTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'received_by');
    }

    /**
     * Get activity logs for this user
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is office head
     */
    public function isOfficeHead(): bool
    {
        return $this->role === 'office_head';
    }

    /**
     * Check if user is office staff
     */
    public function isOfficeStaff(): bool
    {
        return $this->role === 'office_staff';
    }

    /**
     * Get pending documents count for user's office
     */
    public function getPendingDocumentsCount(): int
    {
        if ($this->isAdmin()) {
            return Transfer::where('status', 'pending')->count();
        }
        return $this->office->getPendingTransfersCount();
    }
}
