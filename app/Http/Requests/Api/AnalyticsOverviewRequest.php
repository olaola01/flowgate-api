<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates analytics overview and timeseries query parameters.
 */
class AnalyticsOverviewRequest extends FormRequest
{
    /**
     * Determine if the request is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules for the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'project_id' => ['nullable', 'integer', 'exists:projects,id'],
        ];
    }

    /**
     * Document query parameters for Scribe.
     *
     * @return array<string, array<string, mixed>>
     */
    public function queryParameters(): array
    {
        return [
            'from' => [
                'description' => 'Window start (inclusive).',
                'example' => '2026-03-03 00:00:00',
            ],
            'to' => [
                'description' => 'Window end (inclusive).',
                'example' => '2026-03-04 00:00:00',
            ],
            'project_id' => [
                'description' => 'Optional project filter.',
                'example' => 1,
            ],
        ];
    }
}
