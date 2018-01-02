<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Action\Error;

use CVeeHub\Domain\Exception\PageNotFoundHttpException;
use CVeeHub\Presentation\Action\Error\ErrorAction;
use CVeeHub\Presentation\Action\Error\PageNotFoundAction;
use CVeeHub\Presentation\Responder\Error\ErrorResponderPart;
use CVeeHub\Presentation\Testing\FakeRequest;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Action\Error\PageNotFoundAction
 * @covers \CVeeHub\Presentation\Action\Error\ErrorAction
 * @covers \CVeeHub\Presentation\Responder\Error\ErrorResponderPart
 * @covers \CVeeHub\Presentation\Responder\Traits\JsonResponderTrait
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart
 */
class PageNotFoundActionTest extends AbstractIntegrationTestCase
{
    public function testInvokeWithThrowableReturnsCorrectResponse()
    {
        $subject = new PageNotFoundAction(
            new ErrorAction(new ErrorResponderPart()),
            PageNotFoundHttpException::create()
        );

        $response = $subject(
            new FakeRequest(),
            new Response()
        );

        $this->assertEquals(
            404,
            $response->getStatusCode(),
            'The response status does not match the expected status code.'
        );

        $this->assertEquals(
            'Page not found.',
            $response->getReasonPhrase(),
            'The response reason phrase does not match the expected reason phrase.'
        );

        $expectedBody = '{"error":{"code":404,"message":"Page not found."}}';

        $this->assertEquals(
            $expectedBody,
            (string) $response->getBody(),
            'The response body does not match the expected body.'
        );
    }
}
