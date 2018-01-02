<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Entity\Traits;

use DateTime;

trait TracksCreatedAtTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAt()
    {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
}
