<?php declare(strict_types=1);

namespace CVeeHub\Test\Unit\Domain\Exception;

use CVeeHub\Domain\Exception\PageNotFoundHttpException;
use CVeeHub\Test\Unit\Domain\Exception\Contract\AbstractSimplifiedExceptionTestCase;
use Exception;

class PageNotFoundHttpExceptionTest extends AbstractSimplifiedExceptionTestCase
{
    protected const EXPECTED_MESSAGE = 'Page not found.';

    protected const EXPECTED_CODE = 404;

    public function testCreateReturnsExceptionWithExpectedMessageAndCode()
    {
        $subject = PageNotFoundHttpException::create();

        $this->assertCorrectCreate($subject);
    }

    public function testWithPreviousReturnsExceptionWithExpectedMessageAndCodeAndPrevious()
    {
        $exception = new Exception('Testing previous.');

        $subject = PageNotFoundHttpException::withPrevious($exception);

        $this->assertCorrectWithPrevious($subject, $exception);
    }
}
