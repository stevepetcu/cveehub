<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Repository\Model;

use CVeeHub\Infrastructure\Repository\Model\AppInfoRepository;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;

/**
 * @covers \CVeeHub\Infrastructure\Repository\Model\AppInfoRepository
 */
class AppInfoRepositoryTest extends AbstractIntegrationTestCase
{
    /** @var  AppInfoRepository */
    private $subject;

    public function setUp()
    {
        parent::setUp();

        $this->container->set('application.name', 'test-name');
        $this->container->set('application.version', 'test-version');
        $this->container->set('application.source', 'test-source');

        $this->subject = $this->container->get(AppInfoRepository::class);
    }

    public function testFindReturnsExpectedArray()
    {
        $this->assertSame(
            [
                'name' => 'test-name',
                'version' => 'test-version',
                'source' => 'test-source',
            ],
            $this->subject->find()
        );
    }
}
