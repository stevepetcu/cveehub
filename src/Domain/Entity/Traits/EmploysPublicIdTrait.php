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

trait EmploysPublicIdTrait
{
    /**
     * @ORM\Column(name="public_id", type="string", length=17)
     */
    private $publicId;

    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    public function setPublicId(string $id)
    {
        $this->publicId = $id;
    }
}
