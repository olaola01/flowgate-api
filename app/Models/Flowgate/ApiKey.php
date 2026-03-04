<?php

namespace App\Models\Flowgate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Stores hashed API credentials and lifecycle metadata.
 */
class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'rate_limit_policy_id',
        'name',
        'key_prefix',
        'key_hash',
        'status',
        'last_used_at',
        'expires_at',
        'revoked_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    /**
     * Get the project that owns this key.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the policy assigned to this key.
     */
    public function policy(): BelongsTo
    {
        return $this->belongsTo(RateLimitPolicy::class, 'rate_limit_policy_id');
    }

    /**
     * Determine whether the key is currently usable.
     */
    public function isActive(): bool
    {
        if ($this->status !== 'active' || $this->revoked_at !== null) {
            return false;
        }

        if ($this->expires_at !== null && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }
}
