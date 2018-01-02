<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Middleware\ContentNegotiation;

use CVeeHub\Presentation\ContentType\ContentTypeApplicationJson;
use CVeeHub\Presentation\ContentType\ContentTypeApplicationXml;
use CVeeHub\Presentation\ContentType\ContentTypeTextXml;
use CVeeHub\Presentation\ContentType\Contract\AbstractContentType;
use CVeeHub\Presentation\Middleware\ContentNegotiation\ContentNegotiationMiddleware;
use CVeeHub\Presentation\Testing\FakeRequest;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Body;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Middleware\ContentNegotiation\ContentNegotiationMiddleware
 */
class ContentNegotiationMiddlewareTest extends AbstractIntegrationTestCase
{
    private const AVAILABLE_CONTENT_TYPES_FAIL_MESSAGE = 'The available content types should preserve the order '
    . 'of appearance - and implicitly, the indexes - which they had in the content negotiation middleware constructor.';

    private const PREFERRED_CONTENT_TYPES_FAIL_MESSAGE = 'The preferred content types should preserve the order'
    . " of appearance - and implicitly, the indexes - which they had in the Request's Accept header.";

    /** @var  ServerRequestInterface */
    private $request;

    /** @var  ResponseInterface */
    private $response;

    /** @var  callable */
    private $next;

    /** @var  ContentNegotiationMiddleware */
    private $subject;

    public function setUp()
    {
        parent::setUp();

        $this->request = new FakeRequest();

        $this->response = new Response();

        $this->next = function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
            $response = $response->withBody(
                new Body(fopen('php://temp', 'r+'))
            );

            $response->getBody()->write(json_encode([
                'PreferredContentTypes' => array_map(
                    function ($contentType) {
                        return (string) $contentType;
                    },
                    $request->getAttribute('PreferredContentTypes')
                ),
                'AvailableContentTypes' => array_map(
                    function (AbstractContentType $contentType) {
                        return (string) $contentType;
                    },
                    $request->getAttribute('AvailableContentTypes')
                ),
            ]));

            return $response;
        };

        $this->subject = new ContentNegotiationMiddleware(
            new ContentTypeTextXml(),
            new ContentTypeApplicationXml(),
            new ContentTypeApplicationJson()
        );
    }

    public function testInvokingWithListOfPreferredContentTypesSelectsTheMutuallyBestContentType()
    {
        $request = $this->request
            ->withHeader('Accept', 'text/html, application/json, text/xml; charset=UTF-8');

        /** @var ResponseInterface $response */
        $response = ($this->subject)($request, $this->response, $this->next);

        $this->assertEquals(
            [
                1 => 'application/json',
                2 => 'text/xml'
            ],
            json_decode((string)$response->getBody(), true)['PreferredContentTypes'],
            self::PREFERRED_CONTENT_TYPES_FAIL_MESSAGE
        );

        $this->assertEquals(
            [
                0 => 'text/xml',
                1 => 'application/xml',
                2 => 'application/json'
            ],
            json_decode((string)$response->getBody(), true)['AvailableContentTypes'],
            self::AVAILABLE_CONTENT_TYPES_FAIL_MESSAGE
        );
    }

    public function testTryingToNewUpWithoutParametersThrowsException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('At least one ContentType must be added to a ContentNegotiationMiddleware.');

        new ContentNegotiationMiddleware();
    }

    public function testRequestsWithoutAcceptHeadersUseTheContentTypesSetOnTheMiddlewareByDefault()
    {
        $request = $this->request->withHeader('Accept', '*/*');

        /** @var ResponseInterface $response */
        $response = ($this->subject)($request, $this->response, $this->next);

        $expectedContentTypes = [
            0 => 'text/xml',
            1 => 'application/xml',
            2 => 'application/json'
        ];

        $this->assertEquals(
            $expectedContentTypes,
            json_decode((string)$response->getBody(), true)['PreferredContentTypes'],
            self::PREFERRED_CONTENT_TYPES_FAIL_MESSAGE
        );

        $this->assertEquals(
            $expectedContentTypes,
            json_decode((string)$response->getBody(), true)['AvailableContentTypes'],
            self::AVAILABLE_CONTENT_TYPES_FAIL_MESSAGE
        );
    }

    public function testRequestsWithAcceptAnythingHeadersUseTheContentTypesSetOnTheMiddlewareByDefault()
    {
        $expectedContentTypes = [
            0 => 'text/xml',
            1 => 'application/xml',
            2 => 'application/json'
        ];

        /** @var ResponseInterface $response */
        $response = ($this->subject)($this->request, $this->response, $this->next);

        $this->assertEquals(
            $expectedContentTypes,
            json_decode((string)$response->getBody(), true)['PreferredContentTypes'],
            self::PREFERRED_CONTENT_TYPES_FAIL_MESSAGE
        );

        $this->assertEquals(
            $expectedContentTypes,
            json_decode((string)$response->getBody(), true)['AvailableContentTypes'],
            self::AVAILABLE_CONTENT_TYPES_FAIL_MESSAGE
        );
    }

    public function testUnacceptableContentTypesWillResultInAnEmptyPreferredContentTypesRequestAttribute()
    {
        $request = $this->request->withHeader('Accept', 'text/xml; charset=UTF-8');

        $subject = new ContentNegotiationMiddleware(new ContentTypeApplicationJson());

        /** @var ResponseInterface $response */
        $response = $subject($request, $this->response, $this->next);

        $this->assertEmpty(json_decode((string)$response->getBody(), true)['PreferredContentTypes']);

        $this->assertEquals(
            [
                0 => 'application/json'
            ],
            json_decode((string)$response->getBody(), true)['AvailableContentTypes'],
            self::AVAILABLE_CONTENT_TYPES_FAIL_MESSAGE
        );
    }
}
