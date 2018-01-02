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

use CVeeHub\Domain\Entity\Traits\EmploysPublicIdTrait;
use CVeeHub\Domain\Entity\Traits\TracksCreatedAtTrait;
use CVeeHub\Domain\Entity\Traits\TracksUpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="website",
 *     indexes={
 *         @ORM\Index(name="idx_type_id", columns={"type_id"})
 *     }
 * )
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Website
{
    use TracksCreatedAtTrait, TracksUpdatedAtTrait, EmploysPublicIdTrait;

    /**
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserAccount", inversedBy="websites")
     * @ORM\JoinColumn(name="user_account_id", referencedColumnName="id", nullable=false)
     */
    private $userAccount;

    /**
     * @ORM\ManyToOne(targetEntity="CVeeHub\Domain\Entity\WebsiteType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(name="url", type="string", length=512)
     */
    private $url;

    public function __construct(UserAccount $userAccount, WebsiteType $type, string $url)
    {
        $this->userAccount = $userAccount;
        $this->type = $type;
        $this->url = $url;
    }

    public function setType(WebsiteType $type)
    {
        $this->type = $type;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): WebsiteType
    {
        return $this->type;
    }

    public function getUserAccount(): ?UserAccount
    {
        return $this->userAccount;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
