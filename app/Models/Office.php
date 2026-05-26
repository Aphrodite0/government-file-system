<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_name',
        'office_code',
        'department',
        'email',
        'phone',
        'address',
        'head_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all users in this office
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all documents created by this office
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get all transfers sent by this office
     */
    public function sentTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'from_office_id');
    }

    /**
     * Get all transfers received by this office
     */
    public function receivedTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'to_office_id');
    }

    /**
     * Get activity logs for this office
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get office head
     */
    public function head()
    {
        return $this->users()->where('role', 'office_head')->first();
    }

    /**
     * Get total documents count
     */
    public function getTotalDocumentsCount(): int
    {
        return $this->documents()->count();
    }

    /**
     * Get pending transfers count
     */
    public function getPendingTransfersCount(): int
    {
        return $this->receivedTransfers()->where('status', 'pending')->count();
    }

    /**
     * Get recent activity
     */
    public function getRecentActivity($limit = 10)
    {
        return $this->activityLogs()->latest()->limit($limit)->get();
    }
}
