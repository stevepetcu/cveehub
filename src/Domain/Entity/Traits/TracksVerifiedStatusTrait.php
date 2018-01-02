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

trait TracksVerifiedStatusTrait
{
    /**
     * @ORM\Column(name="is_verified", type="boolean")
     */
    private $isVerified = false;

    public function setIsVerified(bool $isVerified)
    {
        $this->isVerified = $isVerified;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }
}
