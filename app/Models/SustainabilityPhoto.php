<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SustainabilityPhoto extends Model
{
    protected $fillable = ['sustainability_id','path'];

    public function sustainability(): BelongsTo
    {
        return $this->belongsTo(Sustainability::class);
    }
}



