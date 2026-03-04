<?php

namespace App\Data\Flowgate;

use App\Models\Flowgate\ApiKey;

/**
 * Carries an API key model with the newly generated plaintext secret.
 */
class ApiKeySecretData
{
    /**
     * Create a new key secret payload.
     */
    public function __construct(
        public readonly ApiKey $apiKey,
        public readonly string $plainKey,
    ) {}
}
