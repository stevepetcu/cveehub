<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Factory\Bootstrap;

use AppendIterator;
use CVeeHub\Infrastructure\Factory\Contract\SimpleFactoryInterface;
use DirectoryIterator;

class ConfigurationFactory implements SimpleFactoryInterface
{
    private $configurationPaths;

    public function __construct(array $configurationPaths)
    {
        $this->configurationPaths = $configurationPaths;
    }

    public function create(): array
    {
        $configDirectories = $this->getConfigDirectoriesIterator();

        $configuration = [];

        /** @var DirectoryIterator $filename */
        foreach ($configDirectories as $filename) {
            if ($filename->isFile()) {
                $configuration = array_replace_recursive($configuration, require $filename->getRealPath());
            }
        }

        return $configuration;
    }

    private function getConfigDirectoriesIterator(): AppendIterator
    {
        $configDirectories = new AppendIterator();

        foreach ($this->configurationPaths as $path) {
            $configDirectories->append(new DirectoryIterator($path));
        }

        return $configDirectories;
    }
}
