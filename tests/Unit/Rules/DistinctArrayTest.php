<?php

namespace Tests\Unit\Rules;

use App\Rules\DistinctArray;
use Tests\TestCase;

class DistinctArrayTest extends TestCase
{
    /** @test */
    public function passes(): void
    {
        $this->assert([1, 2], true);
    }

    /** @test */
    public function fails(): void
    {
        $this->assert([1, 1], false);
    }

    /**
     * Assert the validation rule.
     */
    private function assert(array $value, bool $assert): void
    {
        $rule = new DistinctArray();

        $fail = $this->getMockBuilder(\stdclass::class)
            ->addMethods(['__invoke'])
            ->getMock();

        $fail->expects($assert ? $this->never() : $this->once())
            ->method('__invoke');

        $rule->validate('', $value, \Closure::fromCallable($fail));
    }
}
