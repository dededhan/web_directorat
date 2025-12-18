<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KatsinovIndicator extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'weight',
        'max_score',
        'order',
        'is_active',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'weight' => 'decimal:2',
        'max_score' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category for this indicator
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(KatsinovCategory::class, 'category_id');
    }

    /**
     * Scope for active indicators only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
