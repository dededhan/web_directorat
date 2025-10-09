<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheImpactSdg extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'title',
        'subtitle',
        'color',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function contents()
    {
        return $this->hasMany(TheImpactContent::class, 'sdg_id');
    }

    public function rootContents()
    {
        return $this->contents()->whereNull('parent_id')->orderBy('order');
    }
}
