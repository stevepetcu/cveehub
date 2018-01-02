<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Representation\Builder;

use CVeeHub\Domain\Model\AppInfo;
use CVeeHub\Presentation\Representation\Builder\Contract\AbstractRepresentationBuilder;
use CVeeHub\Presentation\Representation\Builder\Contract\JsonRepresentationBuilderInterface;
use CVeeHub\Presentation\Representation\Builder\Contract\XmlRepresentationBuilderInterface;
use TypeError;

class AppInfoRepresentationBuilder extends AbstractRepresentationBuilder implements
    JsonRepresentationBuilderInterface,
    XmlRepresentationBuilderInterface
{
    /** @var  AppInfo */
    private $appInfo;

    public function setResource($appInfo): self
    {
        if (!$appInfo instanceof AppInfo) {
            throw new TypeError('Resource should be of type ' . AppInfo::class . '.');
        }

        $this->appInfo = $appInfo;

        return $this;
    }

    public function jsonRepresentation(): array
    {
        return [
            'name' => $this->appInfo->getName(),
            'version' => $this->appInfo->getVersion(),
            'source' => $this->appInfo->getSource(),
        ];
    }

    public function xmlRepresentation(): string
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<application>
  <name>{$this->appInfo->getName()}</name>
  <version>{$this->appInfo->getVersion()}</version>
  <source>{$this->appInfo->getSource()}</source>
</application>
XML;
    }
}
