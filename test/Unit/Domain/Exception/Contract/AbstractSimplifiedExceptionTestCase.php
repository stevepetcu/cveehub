<?php declare(strict_types=1);

namespace CVeeHub\Test\Unit\Domain\Exception\Contract;

use CVeeHub\Domain\Exception\Contract\SimplifiedExceptionInterface;
use PHPUnit\Framework\TestCase;
use Throwable;

abstract class AbstractSimplifiedExceptionTestCase extends TestCase
{
    protected const EXPECTED_MESSAGE = '';
    protected const EXPECTED_CODE = '';

    protected function assertCorrectCreate(SimplifiedExceptionInterface $subject)
    {
        $this->assertEquals(
            static::EXPECTED_MESSAGE,
            $subject->getMessage(),
            'The expected exception message does not match the actual message.'
        );

        $this->assertEquals(
            static::EXPECTED_CODE,
            $subject->getCode(),
            'The expected exception code does not match the actual code.'
        );
    }

    protected function assertCorrectWithPrevious(SimplifiedExceptionInterface $subject, Throwable $previous)
    {
        $this->assertSame(
            $previous,
            $subject->getPrevious(),
            'The expected previous exception does not match the actual exception.'
        );
    }
}
