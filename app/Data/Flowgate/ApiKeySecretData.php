<?php

namespace App\Data\Flowgate;

use App\Models\Flowgate\ApiKey;

class ApiKeySecretData
{
    public function __construct(
        public readonly ApiKey $apiKey,
        public readonly string $plainKey,
    ) {}
}
