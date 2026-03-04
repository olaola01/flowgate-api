<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreApiKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'rate_limit_policy_id' => ['nullable', 'integer', 'exists:rate_limit_policies,id'],
            'name' => ['required', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date'],
        ];
    }
}
