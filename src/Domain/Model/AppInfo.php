<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Model;

class AppInfo
{
    private $name;

    private $version;

    private $source;

    public function __construct(string $name, string $version, string $source)
    {
        $this->name = $name;
        $this->version = $version;
        $this->source = $source;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getSource(): string
    {
        return $this->source;
    }
}
