<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheImpactContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'sdg_id',
        'parent_id',
        'point_number',
        'title',
        'content_type',
        'content',
        'link_url',
        'year',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'link_url' => 'array',
    ];

    public function sdg()
    {
        return $this->belongsTo(TheImpactSdg::class, 'sdg_id');
    }

    public function parent()
    {
        return $this->belongsTo(TheImpactContent::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TheImpactContent::class, 'parent_id')->orderBy('order');
    }

    public function getDepthAttribute()
    {
        $depth = 0;
        $parent = $this->parent;
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }
        return $depth;
    }
}
