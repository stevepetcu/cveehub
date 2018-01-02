<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Repository\Entity;

use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository;
use CVeeHub\Infrastructure\Testing\Traits\UserAccountFixtureTrait;
use CVeeHub\Test\Contract\AbstractDatabaseIntegrationTestCase;
use DateTime;
use Doctrine\ORM\NoResultException;

/**
 * @covers \CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository
 * @covers \CVeeHub\Infrastructure\Repository\Contract\AbstractEntityRepository
 * @covers \CVeeHub\Domain\Entity\UserAccount
 * @covers \CVeeHub\Infrastructure\Testing\Traits\UserAccountFixtureTrait
 * @covers \CVeeHub\Infrastructure\Container\Definition\RepositoryDefinition
 */
class UserAccountRepositoryTest extends AbstractDatabaseIntegrationTestCase
{
    use UserAccountFixtureTrait;

    /** @var  UserAccountRepository */
    private $subject;

    public function setUp()
    {
        parent::setUp();

        $this->subject = $this->container->get(UserAccountRepository::class);
    }

    public function assertPreConditions()
    {
        parent::assertPreConditions();

        $this->assertEmpty(
            $this->subject->findAll(),
            'There should be no registered user accounts.'
        );
    }

    public function testItCanSaveAndRetrieveAUserAccountByItsUrn()
    {
        $userAccount = $this->populateUsers();

        $retrieved = $this->subject->findSingleResultByUrn('stefan-petcu');

        $this->assertEquals(
            1,
            $retrieved->getId(),
            'User account should have an id of 1.');

        $this->assertEquals(
            $retrieved->getEmails(),
            $userAccount->getEmails()
        );

        $this->assertEmpty(
            $retrieved->getPhoneNumbers(),
            'A new user account should have no phone numbers.'
        );

        $this->assertEmpty(
            $retrieved->getWebsites(),
            'A new user account should have no websites.'
        );

        $this->assertInstanceOf(
            DateTime::class,
            $retrieved->getCreatedAt(),
            'createdAt field should have been populated.'
        );

        $this->assertInstanceOf(
            DateTime::class,
            $retrieved->getUpdatedAt(),
            'updatedAt field should have been populated.'
        );
    }

    public function testItThrowsNoResultExceptionWhenNoUserIsFoundByUrn()
    {
        $this->expectException(NoResultException::class);

        $this->subject->findSingleResultByUrn('foo-bar');
    }

    private function assertCorrectUserAccount(UserAccount $userAccount)
    {
        $this->assertEquals(
            'Stefan',
            $userAccount->getUser()->getFirstName(),
            'Generated user account name should be "Stefan".'
        );

        $this->assertEquals(
            'Petcu',
            $userAccount->getUser()->getLastName(),
            'Generated user account last name should be "Petcu".'
        );

        $this->assertNull(
            $userAccount->getUser()->getDateOfBirth(),
            'Generated user account date of birth should be null.'
        );

        $this->assertEquals(
            'Internet',
            $userAccount->getIndustry()->getName(),
            'Generated user account industry name should be "Internet".'
        );

        $this->assertEquals(
            'active',
            $userAccount->getStatus()->getName(),
            'Generated user account status name should be "active".'
        );

        $this->assertEquals(
            'stefan-petcu',
            $userAccount->getUrn(),
            'Generated user account URN should be "stefan-petcu".'
        );

        $address = $userAccount->getUser()->getAddress();
        $country = $userAccount->getUser()->getAddress()->getCountry();

        $this->assertEquals('UK', $country->getCode());
        $this->assertEquals('United Kingdom', $country->getName());
        $this->assertEquals('44', $country->getPhonePrefix());
        $this->assertEquals('SW9 6FY', $address->getPostalCode());
    }

    private function populateUsers(): UserAccount
    {
        $userAccount = $this->userAccount();

        $this->assertCorrectUserAccount($userAccount);

        $this->subject->save($userAccount);

        return $userAccount;
    }
}
