<?php

namespace App\Models\Flowgate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Captures individual gateway request telemetry events.
 */
class RequestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'api_key_id',
        'method',
        'route',
        'status_code',
        'latency_ms',
        'request_bytes',
        'response_bytes',
        'client_ip',
        'user_agent',
        'trace_id',
        'rate_limited',
        'created_at',
    ];

    protected $casts = [
        'rate_limited' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Get the project associated with this request.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the API key associated with this request.
     */
    public function apiKey(): BelongsTo
    {
        return $this->belongsTo(ApiKey::class);
    }
}
