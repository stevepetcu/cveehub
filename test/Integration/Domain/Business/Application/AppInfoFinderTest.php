<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Domain\Business\Application;

use CVeeHub\Domain\Business\Application\AppInfoFinder;
use CVeeHub\Domain\Model\AppInfo;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;

/**
 * @covers \CVeeHub\Domain\Business\Application\AppInfoFinder
 * @covers \CVeeHub\Infrastructure\Repository\Model\AppInfoRepository
 * @covers \CVeeHub\Domain\Model\AppInfo
 * @covers \CVeeHub\Infrastructure\Factory\Model\AppInfoFactory
 */
class AppInfoFinderTest extends AbstractIntegrationTestCase
{
    /** @var  AppInfo */
    private $appInfo;

    public function setUp()
    {
        parent::setUp();

        $this->container->set('application.name', 'test-name');
        $this->container->set('application.version', 'test-version');
        $this->container->set('application.source', 'test-source');

        $this->appInfo = $this->container->get(AppInfoFinder::class)->findAppInfo();
    }

    public function testFindAppInfoReturnsExpectedApplicationName()
    {
        $this->assertEquals('test-name', $this->appInfo->getName());
    }

    public function testFindAppInfoReturnsExpectedApplicationVersion()
    {
        $this->assertEquals('test-version', $this->appInfo->getVersion());
    }

    public function testFindAppInfoReturnsExpectedApplicationSource()
    {
        $this->assertEquals('test-source', $this->appInfo->getSource());
    }
}
