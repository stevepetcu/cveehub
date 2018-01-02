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
use CVeeHub\Domain\Entity\Traits\TracksCreatedAtTrait;
use CVeeHub\Domain\Entity\Traits\TracksUpdatedAtTrait;
use CVeeHub\Domain\Model\AbstractStatus;
use CVeeHub\Domain\Model\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Table(
 *     name="user_account",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_idx_urn", columns={"urn"})
 *     },
 *     indexes={
 *         @ORM\Index(name="idx_industry_id", columns={"industry_id"}),
 *         @ORM\Index(name="idx_status_id", columns={"status_id"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class UserAccount
{
    use TracksCreatedAtTrait, TracksUpdatedAtTrait;

    /**
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Embedded(class="CVeeHub\Domain\Model\User", columnPrefix=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="CVeeHub\Domain\Entity\UserAccountStatus", cascade={"persist"})
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="CVeeHub\Domain\Entity\Industry", cascade={"persist"})
     * @ORM\JoinColumn(name="industry_id", referencedColumnName="id", nullable=false)
     */
    private $industry;

    /**
     * @ORM\Column(name="urn", type="string", length=200)
     */
    private $urn;

    /**
     * @ORM\OneToMany(targetEntity="CVeeHub\Domain\Entity\Email", mappedBy="userAccount", cascade={"persist"})
     * @ORM\OrderBy({"isPrimary"="ASC"})
     *
     * @var Email[]
     */
    private $emails = [];

    /**
     * @ORM\OneToMany(targetEntity="CVeeHub\Domain\Entity\PhoneNumber", mappedBy="userAccount", cascade={"persist"})
     * @ORM\OrderBy({"isPrimary"="ASC"})
     *
     * @var PhoneNumber[]
     */
    private $phoneNumbers = [];

    /**
     * @ORM\OneToMany(targetEntity="CVeeHub\Domain\Entity\Website", mappedBy="userAccount", cascade={"persist"})
     * @ORM\OrderBy({"type"="ASC"})
     *
     * @var Website[]
     */
    private $websites = [];

    /**
     * @ORM\OneToOne(targetEntity="CVeeHub\Domain\Entity\Address", cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $address;

    public function __construct(User $user, Email $email)
    {
        $this->user = $user;
        $this->addEmail($email);
    }

    public function setIndustry(Industry $industry)
    {
        $this->industry = $industry;
    }

    public function setStatus(AbstractStatus $status)
    {
        $this->status = $status;
    }

    public function setUrn(string $urn)
    {
        $this->urn = $urn;
    }

    public function addEmail(Email $email)
    {
        $email->setUserAccount($this);

        $this->emails[] = $email;
    }

    public function removeEmail(Email $email)
    {
        $key = array_search($email, $this->emails);

        unset($this->emails[$key]);
    }

    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        $this->phoneNumbers[] = $phoneNumber;
    }

    public function removePhoneNumber(PhoneNumber $phoneNumber)
    {
        $key = array_search($phoneNumber, $this->phoneNumbers);

        unset($this->phoneNumbers[$key]);
    }

    public function addWebsite(Website $website)
    {
        $this->websites[] = $website;
    }

    public function removeWebsite(Website $website)
    {
        $key = array_search($website, $this->websites);

        unset($this->websites[$key]);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getIndustry(): ?Industry
    {
        return $this->industry;
    }

    public function getStatus(): ?AbstractStatus
    {
        return $this->status;
    }

    public function getUrn(): ?string
    {
        return $this->urn;
    }

    /** @return PersistentCollection|Email[] */
    public function getEmails()
    {
        return $this->emails;
    }

    /** @return PersistentCollection|PhoneNumber[] */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /** @return PersistentCollection|Website[] */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @return TracksPrimaryStatusInterface|Email
     */
    public function getPrimaryEmail(): TracksPrimaryStatusInterface
    {
        return $this->filterPrimaryItemIn($this->emails);
    }

    public function getPrimaryPhoneNumber(): TracksPrimaryStatusInterface
    {
        return $this->filterPrimaryItemIn($this->phoneNumbers);
    }

    /**
     * We need this trick because Doctrine does not support relationships between Entities and Embeddable classes.
     * The Address logically belongs to a User, but the user is Embedded inside the UserAccount.
     *
     * @codeCoverageIgnore This is tested through high level Integration and Functional tests, despite coverage reports.
     *
     * @ORM\PostUpdate()
     * @ORM\PostLoad()
     */
    public function lazySetUserAddress()
    {
        $this->user->setAddress($this->address);
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersistUserAddress()
    {
        $this->address = $this->user->getAddress();
    }

    /**
     * @param array|PersistentCollection $collection
     * @return Email
     */
    private function filterPrimaryItemIn($collection): TracksPrimaryStatusInterface
    {
        if ($collection instanceof PersistentCollection) {
            return $collection->filter(
                function(TracksPrimaryStatusInterface $entry) {
                    return $entry->isPrimary();
                }
            )->current();
        }

        return current(
            array_filter(
                $collection,
                function (TracksPrimaryStatusInterface $item) {
                    return $item->isPrimary();
                }
            )
        );
    }
}
