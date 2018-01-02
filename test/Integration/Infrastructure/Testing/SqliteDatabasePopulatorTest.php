<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Testing;

use CVeeHub\Domain\Entity\Industry;
use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Entity\UserAccountStatus;
use CVeeHub\Infrastructure\Testing\SqliteDatabasePopulator;
use CVeeHub\Test\Contract\AbstractDatabaseIntegrationTestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @covers \CVeeHub\Infrastructure\Testing\SqliteDatabasePopulator
 * @covers \CVeeHub\Infrastructure\Container\Definition\DatabasePopulatorDefinition
 * @covers \CVeeHub\Infrastructure\Container\Definition\DoctrineDefinition
 */
class SqliteDatabasePopulatorTest extends AbstractDatabaseIntegrationTestCase
{
    /** @var  EntityManager */
    private $entityManager;

    public function setUp()
    {
        parent::setUp();

        $this->entityManager = $this->container->get(EntityManagerInterface::class);
    }

    public function assertPreConditions()
    {
        parent::assertPreConditions();

        $this->assertEmpty(
            $this->entityManager->find(UserAccountStatus::class, 1),
            'There should be no AccountStatus entries in the database.'
        );

        $this->assertEmpty(
            $this->entityManager->find(Industry::class, 1),
            'There should be no Industry entries in the database.'
        );

        $this->assertEmpty(
            $this->entityManager->find(UserAccount::class, 1),
            'There should be no UserAccount entries in the database.'
        );
    }

    public function testItCanSaveValidDataInTheDatabase()
    {
        $subject = $this->container->get(SqliteDatabasePopulator::class);

        $data = $this->validData();

        foreach ($data as $table => $datum) {
            $subject->setTable($table)->setData($datum)->save();
        }

        /** @var UserAccountStatus $accountStatus */
        $accountStatus = $this->entityManager->find(UserAccountStatus::class, 1);

        $this->assertEquals(
            'unverified',
            $accountStatus->getName(),
            'The saved AccountStatus name should be "unverified".'
        );

        /** @var Industry $industry */
        $industry = $this->entityManager->find(Industry::class, 1);

        $this->assertEquals(
            'Internet',
            $industry->getName(),
            'The saved Industry name should be "Internet".'
        );

        /** @var UserAccount $userAccount */
        $userAccount = $this->entityManager->find(UserAccount::class, 1);

        $this->assertEquals(
            $accountStatus,
            $userAccount->getStatus(),
            'Unexpected AccountStatus for UserAccount.'
        );

        $this->assertEquals(
            $industry,
            $userAccount->getIndustry(),
            'Unexpected Industry for UserAccount.'
        );

        $this->assertEquals(
            'Stefan',
            $userAccount->getUser()->getFirstName(),
            'The saved UserAccount first name should be "Stefan".'
        );

        $this->assertEquals(
            'Petcu',
            $userAccount->getUser()->getLastName(),
            'The saved UserAccount last name should be "Petcu".'
        );

        $this->assertEquals(
            'stefan-petcu',
            $userAccount->getUrn(),
            'The saved UserAccount URN should be "stefan-petcu".'
        );

        $this->assertEquals(
            '1992-03-23',
            $userAccount->getUser()->getDateOfBirth()->format('Y-m-d'),
            'The saved UserAccount date of birth should be "1992-03-23".'
        );

        $this->assertEquals(
            '2017-10-15 09:51:42',
            $userAccount->getCreatedAt()->format('Y-m-d H:i:s'),
            'The saved UserAccount created_at should be "2017-10-15 09:51:42".'
        );

        $this->assertEquals(
            '2017-10-15 09:55:15',
            $userAccount->getUpdatedAt()->format('Y-m-d H:i:s'),
            'The saved UserAccount updated_at should be "2017-10-15 09:55:15".'
        );
    }

    private function validData()
    {
        return [
            'account_status' => [
                'id' => 1,
                'name' => 'unverified'
            ],
            'industry' => [
                'id' => 1,
                'name' => 'Internet'
            ],
            'address' => [
                'id' => 1,
                'country_code' => 'GB',
                'postal_code' => 'SW9 6FY',
                'created_at' => '2017-10-15 09:51:42'
            ],
            'user_account' => [
                'id' => 1,
                'status_id' => 1,
                'industry_id' => 1,
                'address_id' => 1,
                'first_name' => 'Stefan',
                'last_name' => 'Petcu',
                'urn' => 'stefan-petcu',
                'date_of_birth' => '1992-03-23',
                'created_at' => '2017-10-15 09:51:42',
                'updated_at' => '2017-10-15 09:55:15'
            ],
        ];
    }
}
