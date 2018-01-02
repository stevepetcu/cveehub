<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Entity;

use CVeeHub\Domain\Entity\Contract\AbstractEntityStatus;
use CVeeHub\Domain\Model\StatusActive;
use CVeeHub\Domain\Model\StatusInactive;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="account_status",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_idx_status_name", columns={"name"})
 *     }
 * )
 * @ORM\Entity()
 */
class UserAccountStatus extends AbstractEntityStatus
{
    /**
     * @ORM\Column(name="id", type="smallint", options={"unsigned"=true})
     * @ORM\Id
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=25)
     */
    protected $name;

    protected function getValidStatuses(): array
    {
        return [StatusActive::class, StatusInactive::class];
    }
}
