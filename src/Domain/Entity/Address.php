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

use CVeeHub\Domain\Entity\Traits\TracksCreatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="address",
 *     indexes={
 *         @ORM\Index(name="idx_country_code_postal_code", columns={"country_code", "postal_code"})
 *     }
 * )
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Address
{
    use TracksCreatedAtTrait;

    /**
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CVeeHub\Domain\Entity\Country", cascade={"persist"})
     * @ORM\JoinColumn(name="country_code", referencedColumnName="code", nullable=false)
     */
    private $country;

    /**
     * @ORM\Column(name="postal_code", type="string", length=10)
     */
    private $postalCode;

    public function __construct(Country $country, string $postalCode)
    {
        $this->country = $country;
        $this->postalCode = $postalCode;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }
}
