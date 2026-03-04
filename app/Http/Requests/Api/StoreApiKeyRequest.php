<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates payloads for creating API keys.
 */
class StoreApiKeyRequest extends FormRequest
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
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'rate_limit_policy_id' => ['nullable', 'integer', 'exists:rate_limit_policies,id'],
            'name' => ['required', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date'],
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
                'description' => 'Owning project ID.',
                'example' => 1,
            ],
            'rate_limit_policy_id' => [
                'description' => 'Optional policy to attach to this key.',
                'example' => 1,
            ],
            'name' => [
                'description' => 'Friendly API key label.',
                'example' => 'Server Key',
            ],
            'expires_at' => [
                'description' => 'Optional key expiration timestamp.',
                'example' => '2026-12-31 23:59:59',
            ],
        ];
    }
}
