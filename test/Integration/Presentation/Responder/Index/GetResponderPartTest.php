<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Responder\Index;

use CVeeHub\Domain\Model\AppInfo;
use CVeeHub\Presentation\ContentType\ContentTypeTextXml;
use CVeeHub\Presentation\Representation\Builder\AppInfoRepresentationBuilder;
use CVeeHub\Presentation\Responder\Contract\ResponderInterface;
use CVeeHub\Presentation\Responder\Index\GetResponderPart;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Responder\Index\GetResponderPart
 * @covers \CVeeHub\Presentation\Representation\Builder\AppInfoRepresentationBuilder
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResponderPart
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart
 * @covers \CVeeHub\Presentation\Responder\Traits\JsonResponderTrait
 * @covers \CVeeHub\Presentation\Responder\Traits\XmlResponderTrait
 * @covers \CVeeHub\Presentation\Responder\Responder
 */
class GetResponderPartTest extends AbstractIntegrationTestCase
{
    /** @var  GetResponderPart */
    public $subject;

    /** @var  ResponseInterface */
    public $response;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new GetResponderPart(new AppInfoRepresentationBuilder());
        $this->response = new Response();
    }

    public function testWithResponseReturnsInstanceOfResponder()
    {
        $responder = $this->subject->withResponse($this->response);

        $this->assertInstanceOf(ResponderInterface::class, $responder);
        $this->assertInstanceOf(ResponderInterface::class, $responder->withResponse($this->response));
    }

    public function testDefaultContentTypeIsApplicationJson()
    {
        $this->assertEquals('application/json', (string)$this->subject->defaultContentType());
    }

    public function testResponseWithPayloadReturnsExpectedResponse()
    {
        $appInfo = new AppInfo('test-name', 'test-version', 'test-source');

        $response = $this
            ->subject
            ->withResponse($this->response)
            ->withPayload($appInfo)
            ->response();

        $expectedBody = '{"name":"test-name","version":"test-version","source":"test-source"}';

        $this->assertEquals($expectedBody, (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testResponseWithPayloadAndXmlHeaderReturnsExpectedResponse()
    {
        $appInfo = new AppInfo('test-name', 'test-version', 'test-source');

        $response = $this
            ->subject
            ->withResponse($this->response)
            ->withPayload($appInfo)
            ->withContentType((string)(new ContentTypeTextXml()))
            ->response();

        $expectedBody = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<application>
  <name>test-name</name>
  <version>test-version</version>
  <source>test-source</source>
</application>
XML;

        $this->assertEquals($expectedBody, (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }
}
