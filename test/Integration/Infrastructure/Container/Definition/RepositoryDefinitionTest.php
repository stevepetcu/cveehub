<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Container\Definition;

use CVeeHub\Infrastructure\Repository\Entity\CountryRepository;
use CVeeHub\Infrastructure\Repository\Entity\IndustryRepository;
use CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;

/**
 * @covers \CVeeHub\Infrastructure\Container\Definition\RepositoryDefinition
 */
class RepositoryDefinitionTest extends AbstractIntegrationTestCase
{
    public function testItDefinesTheUserAccountRepository()
    {
        $this->assertInstanceOf(
            UserAccountRepository::class,
            $this->container->get(UserAccountRepository::class)
        );
    }

    public function testItDefinesTheIndustryRepository()
    {
        $this->assertInstanceOf(
            IndustryRepository::class,
            $this->container->get(IndustryRepository::class)
        );
    }

    public function testItDefinesTheCountryRepository()
    {
        $this->assertInstanceOf(
            CountryRepository::class,
            $this->container->get(CountryRepository::class)
        );
    }
}
