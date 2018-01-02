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

trait TracksPrimaryStatusTrait
{
    /**
     * @ORM\Column(name="is_primary", type="boolean")
     */
    private $isPrimary;

    public function setIsPrimary(bool $isPrimary)
    {
        $this->isPrimary = $isPrimary;
    }

    public function isPrimary(): bool
    {
        return $this->isPrimary;
    }
}
