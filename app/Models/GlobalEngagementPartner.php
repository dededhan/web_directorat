<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalEngagementPartner extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo_path', 'website_url', 'order'];
}