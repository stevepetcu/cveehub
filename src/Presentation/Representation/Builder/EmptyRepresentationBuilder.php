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

use CVeeHub\Presentation\Representation\Builder\Contract\AbstractRepresentationBuilder;
use CVeeHub\Presentation\Representation\Builder\Contract\JsonRepresentationBuilderInterface;

class EmptyRepresentationBuilder extends AbstractRepresentationBuilder implements
    JsonRepresentationBuilderInterface
{
    public function setResource($resource)
    {
        return $this;
    }

    public function jsonRepresentation(): ?array
    {
        return null;
    }
}
