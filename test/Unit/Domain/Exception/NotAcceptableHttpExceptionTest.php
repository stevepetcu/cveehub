<?php declare(strict_types=1);

namespace CVeeHub\Test\Unit\Domain\Exception;

use CVeeHub\Domain\Exception\NotAcceptableHttpException;
use CVeeHub\Test\Unit\Domain\Exception\Contract\AbstractSimplifiedExceptionTestCase;
use Exception;

class NotAcceptableHttpExceptionTest extends AbstractSimplifiedExceptionTestCase
{
    protected const EXPECTED_MESSAGE = 'Requested media type not available.';

    protected const EXPECTED_CODE = 406;

    public function testCreateReturnsExceptionWithExpectedMessageAndCode()
    {
        $subject = NotAcceptableHttpException::create();

        $this->assertCorrectCreate($subject);
    }

    public function testWithPreviousReturnsExceptionWithExpectedMessageAndCodeAndPrevious()
    {
        $exception = new Exception('Testing previous.');

        $subject = NotAcceptableHttpException::withPrevious($exception);

        $this->assertCorrectWithPrevious($subject, $exception);
    }

    public function testWithAvailableContentTypesReturnsExceptionWithExpectedMessageAndCodeAndPreviousException()
    {
        $exception = new Exception('Testing previous.');

        $subject = NotAcceptableHttpException::withAvailableContentTypes(['type1', 'type2'], $exception);

        $this->assertEquals(
            self::EXPECTED_MESSAGE . " Must be one of: type1, type2.",
            $subject->getMessage(),
            'The expected exception message does not match the actual message.'
        );

        $this->assertEquals(
            self::EXPECTED_CODE,
            $subject->getCode(),
            'The expected exception code does not match the actual code.'
        );

        $this->assertSame(
            $exception,
            $subject->getPrevious(),
            'The expected previous exception does not match the actual exception.'
        );
    }
}
