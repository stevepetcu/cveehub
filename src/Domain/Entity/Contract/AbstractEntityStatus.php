<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Entity\Contract;

use CVeeHub\Domain\Model\AbstractStatus;
use InvalidArgumentException;

abstract class AbstractEntityStatus extends AbstractStatus
{
    public function __construct(AbstractStatus $status)
    {
        if (!in_array(get_class($status), $this->getValidStatuses())) {
            throw new InvalidArgumentException(
                sprintf("Invalid status %s for %s.", get_class($status), static::class)
            );
        }

        $this->id = $status->getId();
        $this->name = $status->getName();
    }

    abstract protected function getValidStatuses(): array;
}
