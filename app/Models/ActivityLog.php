<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_id',
        'action',
        'resource_type',
        'resource_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the user associated with this activity
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the office associated with this activity
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Get action icon
     */
    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'upload' => 'fa-upload',
            'download' => 'fa-download',
            'transfer' => 'fa-exchange-alt',
            'receive' => 'fa-inbox',
            'delete' => 'fa-trash',
            'update' => 'fa-edit',
            'reject' => 'fa-times-circle',
            default => 'fa-circle',
        };
    }

    /**
     * Get action badge color
     */
    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'login' => 'success',
            'logout' => 'info',
            'upload' => 'primary',
            'download' => 'info',
            'transfer' => 'warning',
            'receive' => 'success',
            'delete' => 'danger',
            'update' => 'warning',
            'reject' => 'danger',
            default => 'secondary',
        };
    }
}
