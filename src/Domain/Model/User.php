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

use CVeeHub\Domain\Entity\Address;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class User
{
    /**
     * @ORM\Column(name="first_name", type="string", length=100)
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(name="date_of_birth", type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * This logically belongs here, but we can't have relationships in an embeddable class,
     * so this is actually reflected from the UserAccount entity.
     */
    private $address;

    public function __construct(string $firstName, string $lastName, Address $address)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function setDateOfBirth(?DateTime $dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function setAddress(?Address $address)
    {
        $this->address = $address;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDateOfBirth(): ?DateTime
    {
        return $this->dateOfBirth;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
