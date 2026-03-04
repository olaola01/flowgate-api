<?php

namespace App\Models\Flowgate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RateLimitPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'requests_per_minute',
        'requests_per_hour',
        'burst_limit',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
