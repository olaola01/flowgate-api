<?php

namespace App\Models\Flowgate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents an upstream API project configured in Flowgate.
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'upstream_base_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get API keys belonging to the project.
     */
    public function apiKeys(): HasMany
    {
        return $this->hasMany(ApiKey::class);
    }

    /**
     * Get rate limit policies belonging to the project.
     */
    public function policies(): HasMany
    {
        return $this->hasMany(RateLimitPolicy::class);
    }
}
