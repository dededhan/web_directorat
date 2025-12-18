<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KatsinovCategory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'weight',
        'order',
        'is_active',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get indicators for this category
     */
    public function indicators(): HasMany
    {
        return $this->hasMany(KatsinovIndicator::class, 'category_id')->orderBy('order');
    }

    /**
     * Scope for active categories only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
