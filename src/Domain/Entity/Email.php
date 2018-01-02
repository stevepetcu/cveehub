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
 *     name="email",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_idx_public_id", columns={"public_id"}),
 *         @ORM\UniqueConstraint(name="unique_idx_email", columns={"email"}),
 *         @ORM\UniqueConstraint(
 *             name="unique_idx_user_account_id_is_primary_email",
 *             columns={"user_account_id", "is_primary"}
 *         )
 *     }
 * )
 * @ORM\Entity(repositoryClass="CVeeHub\Infrastructure\Repository\Entity\EmailRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Email implements TracksPrimaryStatusInterface
{
    use TracksCreatedAtTrait, TracksPrimaryStatusTrait, TracksVerifiedStatusTrait, EmploysPublicIdTrait;

    /**
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserAccount", inversedBy="emails")
     * @ORM\JoinColumn(name="user_account_id", referencedColumnName="id", nullable=false)
     */
    private $userAccount;

    /**
     * @ORM\Column(name="email", type="string", length=200)
     */
    private $email;

    public function __construct(string $email, bool $isPrimary = false)
    {
        $this->email = $email;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setUserAccount(UserAccount $userAccount)
    {
        $this->userAccount = $userAccount;
    }
}
