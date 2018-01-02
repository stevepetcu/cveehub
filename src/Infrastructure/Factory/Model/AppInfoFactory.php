<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Factory\Model;

use CVeeHub\Domain\Model\AppInfo;

class AppInfoFactory
{
    public function create(string $name, string $version, string $source): AppInfo
    {
        return new AppInfo($name, $version, $source);
    }
}
