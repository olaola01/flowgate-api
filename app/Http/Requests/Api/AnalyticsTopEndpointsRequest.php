<?php

namespace App\Http\Requests\Api;

class AnalyticsTopEndpointsRequest extends AnalyticsOverviewRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);
    }
}
