<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StructureOrgMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'title',
        'photo',
        'parent_id',
        'order',
        'level',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi: Member parent (atasan)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(StructureOrgMember::class, 'parent_id');
    }

    /**
     * Relasi: Children (bawahan)
     */
    public function children(): HasMany
    {
        return $this->hasMany(StructureOrgMember::class, 'parent_id')
            ->orderBy('order')
            ->orderBy('created_at');
    }

    /**
     * Get all descendants recursively
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get tree structure sebagai array
     */
    public function toTreeArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'photo' => $this->photo,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
            'order' => $this->order,
            'children' => $this->children->map(fn($child) => $child->toTreeArray())->toArray(),
        ];
    }
}
