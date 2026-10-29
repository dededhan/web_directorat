<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HackatonAnnouncement extends Model
{
    use HasFactory;

    protected $table = 'hackaton_announcements';

    protected $fillable = [
        'title',
        'content',
        'type',
        'link_url',
        'link_text',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public const TYPE_LABELS = [
        'info'    => 'Informasi',
        'penting' => 'Penting',
        'urgent'  => 'Mendesak / Urgent',
    ];

    /**
     * Scope only active announcements.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? ucfirst($this->type);
    }

    public function getBadgeClassAttribute(): string
    {
        return match ($this->type) {
            'urgent'  => 'bg-rose-100 text-rose-900 border-rose-300',
            'penting' => 'bg-amber-100 text-amber-900 border-amber-300',
            default   => 'bg-emerald-100 text-emerald-900 border-emerald-300',
        };
    }

    public function getCardBorderClassAttribute(): string
    {
        return match ($this->type) {
            'urgent'  => 'border-rose-600 bg-rose-50/60',
            'penting' => 'border-amber-500 bg-amber-50/60',
            default   => 'border-emerald-700 bg-emerald-50/60',
        };
    }

    public function getIconAttribute(): string
    {
        return match ($this->type) {
            'urgent'  => 'fa-bell text-rose-600',
            'penting' => 'fa-triangle-exclamation text-amber-600',
            default   => 'fa-bullhorn text-emerald-700',
        };
    }
}
