<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Action\Index;

use CVeeHub\Domain\Exception\NotAcceptableHttpException;
use CVeeHub\Presentation\Action\Index\GetAction;
use CVeeHub\Presentation\Testing\FakeRequest;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Action\Index\GetAction
 * @covers \CVeeHub\Presentation\Action\Contract\AbstractAction
 * @covers \CVeeHub\Presentation\Responder\Index\GetResponderPart
 * @covers \CVeeHub\Presentation\Responder\Traits\JsonResponderTrait
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart
 */
class GetActionTest extends AbstractIntegrationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->container->set('application.name', 'test-name');
        $this->container->set('application.version', 'test-ver');
        $this->container->set('application.source', 'test-src');
    }

    public function testInvokeReturnsCorrectResponse()
    {
        $subject = $this->container->get(GetAction::class);

        $response = $subject(new FakeRequest(), new Response());

        $expectedBody = '{"name":"test-name","version":"test-ver","source":"test-src"}';

        $this->assertEquals($expectedBody, (string) $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testInvokeWithSpecifiedContentTypeReturnsExpectedResult()
    {
        $subject = $this->container->get(GetAction::class);

        $request = (new FakeRequest())
            ->withAttribute('PreferredContentTypes', ['application/xml', 'application/json']);

        $response = $subject($request, new Response());

        $expectedBody = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<application>
  <name>test-name</name>
  <version>test-ver</version>
  <source>test-src</source>
</application>
XML;

        $this->assertEquals($expectedBody, (string) $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testInvokeWhenRequestDoesNotHaveAcceptableNorAvailableContentTypesThrowsNotAcceptableHttpException()
    {
        $subject = $this->container->get(GetAction::class);

        $request = (new FakeRequest())->withAttribute('PreferredContentTypes', []);

        $this->expectException(NotAcceptableHttpException::class);
        $this->expectExceptionMessage('Requested media type not available. Must be one of: application/json.');
        $this->expectExceptionCode(406);

        $subject($request, new Response());
    }

    public function testInvokeWhenRequestDoesNotHaveAcceptableContentTypesThrowsNotAcceptableHttpException()
    {
        $subject = $this->container->get(GetAction::class);

        $request = (new FakeRequest())
            ->withAttribute('PreferredContentTypes', [])
            ->withAttribute('AvailableContentTypes', ['application/xml', 'application/json']);

        $this->expectException(NotAcceptableHttpException::class);
        $this->expectExceptionMessage(
            'Requested media type not available. Must be one of: application/xml, application/json.'
        );
        $this->expectExceptionCode(406);

        $subject($request, new Response());
    }
}
