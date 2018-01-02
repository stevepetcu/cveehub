<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Domain\Business\UserAccount;

use CVeeHub\Domain\Business\UserAccount\UserAccountRegistrar;
use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Entity\Country;
use CVeeHub\Domain\Entity\Email;
use CVeeHub\Domain\Entity\Industry;
use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Entity\UserAccountStatus;
use CVeeHub\Domain\Model\User;
use CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository;
use CVeeHub\Infrastructure\Testing\Traits\UserAccountCreateFakeRequestFixtureTrait;
use CVeeHub\Presentation\Request\UserAccount\CreateRequest;
use CVeeHub\Test\Contract\AbstractDatabaseIntegrationTestCase;

/**
 * @covers \CVeeHub\Domain\Business\UserAccount\UserAccountRegistrar
 * @covers \CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository
 */
class UserAccountRegistrarTest extends AbstractDatabaseIntegrationTestCase
{
    use UserAccountCreateFakeRequestFixtureTrait;

    /** @var  UserAccountRegistrar */
    private $subject;

    /** @var  UserAccountRepository */
    private $userAccountRepository;

    public function setUp()
    {
        parent::setUp();

        $this->subject = $this->container->get(UserAccountRegistrar::class);

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

    public function testItCanRegisterANewUserAccountFromACreateUserAccountRequest()
    {
        $request = new CreateRequest($this->userAccountCreateFakeRequest());

        $account = $this->subject->register($request);

        $this->assertCorrectAccount($account);
        $this->assertCorrectStatus($account);
        $this->assertCorrectEmail($account);
        $this->assertCorrectIndustry($account);

        $user = $account->getUser();

        $this->assertCorrectUserName($user);
        $this->assertCorrectAddress($user);
    }

    private function assertCorrectAccount(UserAccount $account)
    {
        $this->assertInstanceOf(
            UserAccount::class,
            $account,
            'The return type of UserAccountRegistrar::register() should be an instance of UserAccount.'
        );

        $this->assertEquals('stefan-petcu', $account->getUrn());
    }

    private function assertCorrectStatus(UserAccount $account)
    {
        $status = $account->getStatus();

        $this->assertInstanceOf(
            UserAccountStatus::class,
            $status,
            'The UserAccount should have a UserAccountStatus.'
        );

        $this->assertEquals(
            'active',
            $status->getName(),
            "The newly created UserAccount's status should be 'active'."
        );
    }

    private function assertCorrectUserName(User $user)
    {
        $this->assertEquals(
            'Stefan',
            $user->getFirstName(),
            "The first name of the UserAccount's User should be 'Stefan'."
        );
        $this->assertEquals(
            'Petcu',
            $user->getLastName(),
            "The last name of the UserAccount's User should be 'Petcu'."
        );
    }

    private function assertCorrectEmail(UserAccount $account)
    {
        $email = $account->getPrimaryEmail();

        $this->assertCount(
            1,
            $account->getEmails(),
            'The UserAccount should have exactly registered 1 email address.'
        );

        $this->assertInstanceOf(
            Email::class,
            $email,
            'The UserAccount should have registered a primary Email.'
        );

        $this->assertEquals(
            'contact@stefanpetcu.com',
            $email->getEmail(),
            "The email address of the primary UserAccount emails should be 'contact@stefanpetcu.com'."
        );
    }

    private function assertCorrectAddress(User $user)
    {
        $address = $user->getAddress();

        $this->assertInstanceOf(
            Address::class,
            $address,
            "The UserAccount's associated User should have an Address."
        );
        $this->assertEquals(
            'SW9 6FY',
            $address->getPostalCode(),
            "The postal code of the UserAccount's associated Address should be 'SW9 6FY'."
        );

        $country = $address->getCountry();

        $this->assertInstanceOf(
            Country::class,
            $country,
            "The UserAccount's Address should have an associated Country."
        );

        $this->assertEquals(
            'GB',
            $country->getCode(),
            "The code of the UserAccount's associated Country should be 'GB'"
        );
        $this->assertEquals(
            'Great Britain',
            $country->getName(),
            "The name of the UserAccount's associated Country should be 'Great Britain'"
        );
        $this->assertEquals(
            '44',
            $country->getPhonePrefix(),
            "The phone prefix of the UserAccount's associated Country should be '44'"
        );
    }

    private function assertCorrectIndustry(UserAccount $account)
    {
        $industry = $account->getIndustry();

        $this->assertInstanceOf(
            Industry::class,
            $industry,
            "The UserAccount's Address should have an associated Industry."
        );

        $this->assertEquals(
            'Internet',
            $industry->getName(),
            "The name of the UserAccount's associated Industry should be 'Internet'"
        );
    }
}
