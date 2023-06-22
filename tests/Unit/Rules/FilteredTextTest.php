<?php

namespace Tests\Unit\Rules;

use App\Rules\FilteredText;
use Tests\TestCase;

class FilteredTextTest extends TestCase
{
    /** @test */
    public function it_passes(): void
    {
        $this->assert('Aa1 !$,."\'()_-', true);
        $this->assert(null, true);
    }

    /** @test */
    public function it_fails(): void
    {
        $this->assert('@', false);
        $this->assert('#', false);
        $this->assert('%', false);
        $this->assert('^', false);
        $this->assert('&', false);
        $this->assert('*', false);
        $this->assert('+', false);
        $this->assert('=', false);
        $this->assert('{', false);
        $this->assert(':', false);
        $this->assert(';', false);
        $this->assert('🍆', false);
    }

    /**
     * Assert the validation rule.
     */
    private function assert(?string $text, bool $assert): void
    {
        $rule = new FilteredText();

        $fail = $this->getMockBuilder(\stdclass::class)
            ->addMethods(['__invoke'])
            ->getMock();

        $fail->expects($assert ? $this->never() : $this->once())
            ->method('__invoke');

        $rule->validate('', $text, \Closure::fromCallable($fail));
    }
}
