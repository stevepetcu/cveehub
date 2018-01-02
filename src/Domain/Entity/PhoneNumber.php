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

use CVeeHub\Domain\Entity\Contract\TracksPrimaryStatusInterface;
use CVeeHub\Domain\Entity\Traits\EmploysPublicIdTrait;
use CVeeHub\Domain\Entity\Traits\TracksCreatedAtTrait;
use CVeeHub\Domain\Entity\Traits\TracksPrimaryStatusTrait;
use CVeeHub\Domain\Entity\Traits\TracksVerifiedStatusTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="phone_number",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_idx_country_code_number", columns={"country_code", "number"}),
 *         @ORM\UniqueConstraint(
 *             name="unique_idx_user_account_id_is_primary_phone_number",
 *             columns={"user_account_id", "is_primary"}
 *         )
 *     }
 * )
 * @ORM\Entity()
 */
class PhoneNumber implements TracksPrimaryStatusInterface
{
    use TracksCreatedAtTrait,
        TracksPrimaryStatusTrait,
        TracksVerifiedStatusTrait,
        EmploysPublicIdTrait;

    /**
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserAccount", inversedBy="phoneNumbers")
     * @ORM\JoinColumn(name="user_account_id", referencedColumnName="id", nullable=false)
     */
    private $userAccount;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_code", referencedColumnName="code", nullable=false)
     */
    private $country;

    /**
     * @ORM\Column(name="number", type="string", length=50)
     */
    private $number;

    public function __construct(
        UserAccount $userAccount,
        Country $country,
        string $number,
        bool $isPrimary
    ) {
        $this->userAccount = $userAccount;
        $this->country = $country;
        $this->number = $number;
        $this->isPrimary = $isPrimary;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserAccount(): ?UserAccount
    {
        return $this->userAccount;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getNumber(): string
    {
        return $this->number;
    }
}
