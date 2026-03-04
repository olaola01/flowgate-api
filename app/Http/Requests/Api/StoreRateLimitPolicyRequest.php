<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates payloads for creating rate limit policies.
 */
class StoreRateLimitPolicyRequest extends FormRequest
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
            'project_id' => ['nullable', 'integer', 'exists:projects,id'],
            'name' => ['required', 'string', 'max:255'],
            'requests_per_minute' => ['required', 'integer', 'min:1'],
            'requests_per_hour' => ['required', 'integer', 'min:1'],
            'burst_limit' => ['required', 'integer', 'min:1'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Document request body parameters for Scribe.
     *
     * @return array<string, array<string, mixed>>
     */
    public function bodyParameters(): array
    {
        return [
            'project_id' => [
                'description' => 'Optional project scope for this policy.',
                'example' => 1,
            ],
            'name' => [
                'description' => 'Policy display name.',
                'example' => 'Starter',
            ],
            'requests_per_minute' => [
                'description' => 'Allowed requests per minute.',
                'example' => 60,
            ],
            'requests_per_hour' => [
                'description' => 'Allowed requests per hour.',
                'example' => 1000,
            ],
            'burst_limit' => [
                'description' => 'Short-term burst allowance.',
                'example' => 120,
            ],
            'is_active' => [
                'description' => 'Whether this policy is active.',
                'example' => true,
            ],
        ];
    }
}
