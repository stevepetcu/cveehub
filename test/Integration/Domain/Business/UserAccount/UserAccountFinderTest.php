<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Domain\Business\UserAccount;

use CVeeHub\Domain\Business\UserAccount\UserAccountFinder;
use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Exception\NotFoundHttpException;
use CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository;
use CVeeHub\Infrastructure\Testing\Traits\UserAccountFixtureTrait;
use CVeeHub\Test\Contract\AbstractDatabaseIntegrationTestCase;

/**
 * @covers \CVeeHub\Domain\Business\UserAccount\UserAccountFinder
 * @covers \CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository
 */
class UserAccountFinderTest extends AbstractDatabaseIntegrationTestCase
{
    use UserAccountFixtureTrait;

    /** @var  UserAccountFinder */
    private $subject;

    /** @var  UserAccountRepository */
    private $userAccountRepository;

    public function setUp()
    {
        parent::setUp();

        $this->subject = $this->container->get(UserAccountFinder::class);

        $this->userAccountRepository = $this->container->get(UserAccountRepository::class);
    }

    public function assertPreConditions()
    {
        parent::assertPreConditions();

        $this->assertEmpty(
            $this->userAccountRepository->findAll(),
            'There should be no registered user accounts.'
        );
    }

    public function testItCanFindAnExistingUserByUrn()
    {
        $userAccount = $this->populateUsers();

        $this->assertEquals($userAccount, $this->subject->findByUrn('stefan-petcu'));
    }

    public function testItThrowsNotFoundHttpExceptionWhenNoUserIsFoundByUrn()
    {
        $this->expectException(NotFoundHttpException::class);

        $this->subject->findByUrn('foo-bar');
    }

    private function populateUsers(): UserAccount
    {
        $userAccount = $this->userAccount();

        $this->userAccountRepository->save($userAccount);

        return $userAccount;
    }
}
