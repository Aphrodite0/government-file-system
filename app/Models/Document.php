<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'created_by',
        'filename',
        'original_name',
        'file_path',
        'file_size',
        'file_type',
        'description',
        'document_category',
        'reference_number',
        'is_classified',
    ];

    protected $casts = [
        'is_classified' => 'boolean',
    ];

    /**
     * Get the office that created this document
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Get the user who created this document
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all transfers of this document
     */
    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }

    /**
     * Get the full file path
     */
    public function getFullPathAttribute(): string
    {
        return storage_path('app/public/' . $this->file_path);
    }

    /**
     * Get file download URL
     */
    public function getDownloadUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute(): string
    {
        return $this->formatBytes($this->file_size);
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Get total transfers count
     */
    public function getTotalTransfersCount(): int
    {
        return $this->transfers()->count();
    }

    /**
     * Get completed transfers count
     */
    public function getCompletedTransfersCount(): int
    {
        return $this->transfers()->where('status', 'received')->count();
    }

    /**
     * Get pending transfers count
     */
    public function getPendingTransfersCount(): int
    {
        return $this->transfers()->where('status', 'pending')->count();
    }
}
