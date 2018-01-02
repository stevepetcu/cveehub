<?php declare(strict_types=1);

namespace CVeeHub\Test\Unit\Domain\Exception;

use CVeeHub\Domain\Exception\NotFoundHttpException;
use CVeeHub\Test\Unit\Domain\Exception\Contract\AbstractSimplifiedExceptionTestCase;
use Exception;

class NotFoundHttpExceptionTest extends AbstractSimplifiedExceptionTestCase
{
    protected const EXPECTED_MESSAGE = 'Resource not found.';

    protected const EXPECTED_CODE = 404;

    public function testCreateReturnsExceptionWithExpectedMessageAndCode()
    {
        $subject = NotFoundHttpException::create();

        $this->assertCorrectCreate($subject);
    }

    public function testWithPreviousReturnsExceptionWithExpectedMessageAndCodeAndPrevious()
    {
        $exception = new Exception('Testing previous.');

        $subject = NotFoundHttpException::withPrevious($exception);

        $this->assertCorrectWithPrevious($subject, $exception);
    }
}
