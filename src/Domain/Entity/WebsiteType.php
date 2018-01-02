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

use CVeeHub\Domain\Model\AbstractWebsiteType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="website_type",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_idx_website_type_name", columns={"name"})
 *     }
 * )
 * @ORM\Entity()
 */
class WebsiteType extends AbstractWebsiteType
{
    /**
     * @ORM\Column(name="id", type="smallint", options={"unsigned"=true})
     * @ORM\Id
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    public function __construct(AbstractWebsiteType $type)
    {
        $this->id = $type->getId();
        $this->name = $type->getName();
    }
}
