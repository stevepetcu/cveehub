<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Business\Application;

use CVeeHub\Domain\Model\AppInfo;
use CVeeHub\Infrastructure\Factory\Model\AppInfoFactory;
use CVeeHub\Infrastructure\Repository\Model\AppInfoRepository;

class AppInfoFinder
{
    private $repository;

    private $factory;

    public function __construct(AppInfoRepository $repository, AppInfoFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function findAppInfo(): AppInfo
    {
        ['name' => $name, 'version' => $version, 'source' => $source] = $this->repository->find();

        return $this->factory->create($name, $version, $source);
    }
}
