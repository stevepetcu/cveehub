<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Responder\Contract;

use CVeeHub\Presentation\ContentType\ContentTypeApplicationJson;
use CVeeHub\Presentation\Representation\Builder\Contract\AbstractRepresentationBuilder;
use CVeeHub\Presentation\Representation\Builder\Contract\JsonRepresentationBuilderInterface;
use CVeeHub\Presentation\Representation\Builder\EmptyRepresentationBuilder;
use CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart
 * @covers \CVeeHub\Presentation\Responder\Traits\JsonResponderTrait
 */
class AbstractResourceResponderPartTest extends AbstractIntegrationTestCase
{
    /** @var  ResponseInterface */
    public $response;

    public function setUp()
    {
        parent::setUp();

        $this->response = new Response();
    }

    public function testResponseWithNoPayloadGeneratesEmptyBodyResponse()
    {
        $subject = new class extends AbstractResourceResponderPart
        {
            public function __construct()
            {
                $this->representationBuilder = new EmptyRepresentationBuilder();
            }
        };

        $response = $subject
            ->withResponse($this->response)
            ->withContentType((string)new ContentTypeApplicationJson())
            ->response();

        $this->assertSame('"{}"', (string) $response->getBody());
    }

    public function testResponseWithUnimplementedContentTypeThrowsLogicException()
    {
        $subject = new class extends AbstractResourceResponderPart
        {
            public function __construct()
            {
                $this->representationBuilder = new class extends AbstractRepresentationBuilder
                {
                    public $resource;

                    public function setResource($resource)
                    {
                        $this->resource = $resource;
                    }

                    public function htmlRepresentation(): array
                    {
                        return ['html' => "<html><body><p>{$this->resource}</p></body></html>"];
                    }
                };
            }
        };

        $class = get_class($subject);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            "Class '$class' does not implement method 'htmlResponse'."
        );

        $subject
            ->withResponse($this->response)
            ->withPayload('test')
            ->withContentType('text/html')
            ->response();
    }

    public function testJsonResponseWithUnencodableResourceThrowsRuntimeError()
    {
        $subject = new class extends AbstractResourceResponderPart
        {
            public function __construct()
            {
                $this->representationBuilder = new class extends AbstractRepresentationBuilder implements
                    JsonRepresentationBuilderInterface
                {
                    public $resource;

                    public function setResource($resource)
                    {
                        $this->resource = $resource;
                    }

                    public function jsonRepresentation(): array
                    {
                        return ['unencodable' => fopen('php://temp', 'r')];
                    }
                };
            }
        };

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Type is not supported');
        $this->expectExceptionCode(8);

        $subject
            ->withResponse($this->response)
            ->withPayload('test')
            ->withContentType((string) new ContentTypeApplicationJson())
            ->response();
    }
}
