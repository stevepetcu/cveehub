<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Repository\Model;

use DI\Container;

class AppInfoRepository
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function find(): array
    {
        $name = $this->container->get('application.name');
        $version = $this->container->get('application.version');
        $source = $this->container->get('application.source');

        return compact('name', 'version', 'source');
    }
}
