<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

#[Group('unit')]
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    #[Test]
    #[Group('unit')]
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
