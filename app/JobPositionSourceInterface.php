<?php

namespace App;

use App\Models\JobPositionSource;

interface JobPositionSourceInterface
{
    /**
     * Sync job positions from the source
     */
    public function sync(JobPositionSource $source): void;

    /**
     * Validate the source credentials
     */
    public function validateCredentials(array $credentials): bool;
}
