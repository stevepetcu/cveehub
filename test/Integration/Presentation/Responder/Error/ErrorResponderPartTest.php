<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Responder\Error;

use CVeeHub\Presentation\Responder\Contract\ResponderInterface;
use CVeeHub\Presentation\Responder\Error\ErrorResponderPart;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Responder\Error\ErrorResponderPart
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResponderPart
 * @covers \CVeeHub\Presentation\Responder\Traits\JsonResponderTrait
 * @covers \CVeeHub\Presentation\Responder\Responder
 */
class ErrorResponderPartTest extends AbstractIntegrationTestCase
{
    /** @var  ErrorResponderPart */
    public $subject;

    /** @var  ResponseInterface */
    public $response;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new ErrorResponderPart();
        $this->response = new Response();
    }

    public function testWithResponseReturnsInstanceOfResponder()
    {
        $responder = $this->subject->withResponse($this->response);

        $this->assertInstanceOf(ResponderInterface::class, $responder);
    }

    public function testResponseWithPayloadReturnsExpectedResponse()
    {
        $error = new Exception('Test message.', 420);

        $response = $this
            ->subject
            ->withResponse($this->response)
            ->withError($error)
            ->withPayload('Test payload.')
            ->response();

        $expectedBody = '{"error":{"code":420,"message":"Test payload."}}';

        $this->assertEquals($expectedBody, (string) $response->getBody());
        $this->assertEquals(420, $response->getStatusCode());
        $this->assertEquals('Test message.', $response->getReasonPhrase());
    }

    public function testResponseWithoutPayloadReturnsExpectedResponse()
    {
        $error = new Exception('Test message.', 420);

        $response = $this
            ->subject
            ->withResponse($this->response)
            ->withError($error)
            ->response();

        $expectedBody = '{"error":{"code":420,"message":"Test message."}}';

        $this->assertEquals($expectedBody, (string) $response->getBody());
        $this->assertEquals(420, $response->getStatusCode());
        $this->assertEquals('Test message.', $response->getReasonPhrase());
    }
}
