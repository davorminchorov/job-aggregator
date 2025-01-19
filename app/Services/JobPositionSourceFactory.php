<?php

namespace App\Services;

use App\JobPositionSourceInterface;
use App\Models\JobPositionSource;
use InvalidArgumentException;

class JobPositionSourceFactory
{
    private array $sources = [];

    public function register(string $key, string $class): void
    {
        if (!is_subclass_of($class, JobPositionSourceInterface::class)) {
            throw new InvalidArgumentException("Class {$class} must implement JobPositionSourceInterface");
        }

        $this->sources[$key] = $class;
    }

    public function make(JobPositionSource $source): JobPositionSourceInterface
    {
        $key = $source->sourceType->key;

        if (!isset($this->sources[$key])) {
            throw new InvalidArgumentException("No source registered for key: {$key}");
        }

        return app($this->sources[$key]);
    }
}
