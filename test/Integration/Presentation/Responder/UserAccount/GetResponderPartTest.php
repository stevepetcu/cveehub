<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Responder\UserAccount;

use CVeeHub\Infrastructure\Testing\Traits\UserAccountFixtureTrait;
use CVeeHub\Presentation\Representation\Builder\UserAccountRepresentationBuilder;
use CVeeHub\Presentation\Responder\Contract\ResponderInterface;
use CVeeHub\Presentation\Responder\UserAccount\GetResponderPart;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Responder\UserAccount\GetResponderPart
 * @covers \CVeeHub\Presentation\Representation\Builder\UserAccountRepresentationBuilder
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResponderPart
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart
 * @covers \CVeeHub\Presentation\Responder\Traits\JsonResponderTrait
 * @covers \CVeeHub\Presentation\Responder\Responder
 */
class GetResponderPartTest extends AbstractIntegrationTestCase
{
    use UserAccountFixtureTrait;

    /** @var  GetResponderPart */
    public $subject;

    /** @var  ResponseInterface */
    public $response;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new GetResponderPart(new UserAccountRepresentationBuilder());
        $this->response = new Response();
    }

    public function testWithResponseReturnsInstanceOfResponder()
    {
        $responder = $this->subject->withResponse($this->response);

        $this->assertInstanceOf(ResponderInterface::class, $responder);
    }

    public function testResponseWithPayloadReturnsExpectedResponse()
    {
        $userAccount = $this->userAccount();

        $response = $this
            ->subject
            ->withResponse($this->response)
            ->withPayload($userAccount)
            ->response();

        $expectedBody = '{"first_name":"Stefan","last_name":"Petcu","industry":"Internet","urn":"stefan-petcu",'
        . '"status":"active","date_of_birth":null,"emails":[{"id":"MDlU9OZtaXmFZ024z",'
        . '"email":"contact@stefanpetcu.com","primary":true,"verified":false}],"phone_numbers":[],"websites":[],'
        . '"address":{"country":{"name":"United Kingdom","code":"UK","phone_prefix":"44"},"postal_code":"SW9 6FY"},'
        . '"created_at":null,"updated_at":null}';

        $this->assertEquals($expectedBody, (string) $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }
}
