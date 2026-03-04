<?php

namespace App\Http\Requests\Api;

/**
 * Extends analytics query validation with endpoint ranking constraints.
 */
class AnalyticsTopEndpointsRequest extends AnalyticsOverviewRequest
{
    /**
     * Get validation rules for the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);
    }

    /**
     * Document query parameters for Scribe.
     *
     * @return array<string, array<string, mixed>>
     */
    public function queryParameters(): array
    {
        return array_merge(parent::queryParameters(), [
            'limit' => [
                'description' => 'Maximum number of ranked endpoints to return.',
                'example' => 10,
            ],
        ]);
    }
}
