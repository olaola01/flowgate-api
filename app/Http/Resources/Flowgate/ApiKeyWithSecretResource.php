<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;

class ApiKeyWithSecretResource extends ApiKeyResource
{
    public function __construct($resource, private readonly ?string $plainKey = null)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'api_key' => $this->plainKey,
        ]);
    }
}
