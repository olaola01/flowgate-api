<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates payloads for creating Flowgate projects.
 */
class StoreProjectRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')],
            'upstream_base_url' => ['required', 'url', 'max:1024'],
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
            'name' => [
                'description' => 'Human-readable project name.',
                'example' => 'Primary API',
            ],
            'slug' => [
                'description' => 'URL-safe unique project identifier.',
                'example' => 'primary-api',
            ],
            'upstream_base_url' => [
                'description' => 'Base URL for proxied upstream traffic.',
                'example' => 'https://api.example.com',
            ],
            'is_active' => [
                'description' => 'Whether the project is active for gateway traffic.',
                'example' => true,
            ],
        ];
    }
}
