<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Action\Error;

use CVeeHub\Presentation\Action\Error\ErrorAction;
use CVeeHub\Presentation\Responder\Error\ErrorResponderPart;
use CVeeHub\Presentation\Testing\FakeRequest;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Exception;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Action\Error\ErrorAction
 * @covers \CVeeHub\Presentation\Action\Contract\AbstractAction
 * @covers \CVeeHub\Presentation\Responder\Error\ErrorResponderPart
 * @covers \CVeeHub\Presentation\Responder\Traits\JsonResponderTrait
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart
 */
class ErrorActionTest extends AbstractIntegrationTestCase
{
    public function testInvokeWithThrowableReturnsCorrectResponse()
    {
        $subject = new ErrorAction(new ErrorResponderPart());

        $response = $subject(
            new FakeRequest(),
            new Response(),
            new Exception('Test message.', 420)
        );

        $this->assertEquals(
            420,
            $response->getStatusCode(),
            'The response status does not match the expected status code.'
        );

        $this->assertEquals(
            'Test message.',
            $response->getReasonPhrase(),
            'The response reason phrase does not match the expected reason phrase.'
        );

        $expectedBody = '{"error":{"code":420,"message":"Test message."}}';

        $this->assertEquals(
            $expectedBody,
            (string) $response->getBody(),
            'The response body does not match the expected body.'
        );
    }
}
