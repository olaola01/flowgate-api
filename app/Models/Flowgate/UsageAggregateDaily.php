<?php

namespace App\Models\Flowgate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageAggregateDaily extends Model
{
    use HasFactory;

    protected $table = 'usage_aggregates_daily';

    protected $fillable = [
        'project_id',
        'api_key_id',
        'bucket_date',
        'route',
        'method',
        'total_requests',
        'blocked_requests',
        'error_requests',
        'latency_sum_ms',
        'latency_p95_ms',
    ];

    protected $casts = [
        'bucket_date' => 'date',
    ];
}
