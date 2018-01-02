<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Presentation\Action\UserAccount;

use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository;
use CVeeHub\Infrastructure\Testing\Traits\UserAccountFixtureTrait;
use CVeeHub\Presentation\Action\UserAccount\GetAction;
use CVeeHub\Presentation\Testing\FakeRequest;
use CVeeHub\Test\Contract\AbstractDatabaseIntegrationTestCase;
use Slim\Http\Response;

/**
 * @covers \CVeeHub\Presentation\Action\UserAccount\GetAction
 * @covers \CVeeHub\Presentation\Action\Contract\AbstractAction
 * @covers \CVeeHub\Presentation\Responder\UserAccount\GetResponderPart
 * @covers \CVeeHub\Presentation\Responder\Traits\JsonResponderTrait
 * @covers \CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart
 */
class GetActionTest extends AbstractDatabaseIntegrationTestCase
{
    use UserAccountFixtureTrait;

    /** @var  UserAccountRepository */
    private $userAccountRepository;

    /** @var  UserAccount */
    private $userAccount;

    public function setUp()
    {
        parent::setUp();

        $this->userAccountRepository = $this->container->get(UserAccountRepository::class);

        $this->userAccount = $this->userAccount();

        $this->userAccountRepository->save($this->userAccount);
    }

    public function testInvokeWithExistingUrnReturnsCorrectResponse()
    {
        $subject = $this->container->get(GetAction::class);

        $response = $subject(new FakeRequest(), new Response(), 'stefan-petcu');

        $expectedBody = '{"first_name":"Stefan","last_name":"Petcu","industry":"Internet","urn":"stefan-petcu",'
            . '"status":"active","date_of_birth":null,"emails":[{"id":"MDlU9OZtaXmFZ024z",'
            . '"email":"contact@stefanpetcu.com","primary":true,"verified":false}],"phone_numbers":[],"websites":[],'
            . '"address":{"country":{"name":"United Kingdom","code":"UK","phone_prefix":"44"},"postal_code":"SW9 6FY"},'
            . '"created_at":"' . $this->userAccount->getCreatedAt()->format('Y-m-d H:i:s')
            . '","updated_at":"' . $this->userAccount->getUpdatedAt()->format('Y-m-d H:i:s') . '"}';

        $this->assertEquals($expectedBody, (string) $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testInvokeWithInexistentUrnReturns404Response()
    {
        $subject = $this->container->get(GetAction::class);

        $response = $subject(new FakeRequest(), new Response(), 'foo-bar');

        $expectedBody = '{"error":{"code":404,"message":"User with unique link \'foo-bar\' does not exist."}}';

        $this->assertEquals($expectedBody, (string) $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Resource not found.', $response->getReasonPhrase());
    }
}
