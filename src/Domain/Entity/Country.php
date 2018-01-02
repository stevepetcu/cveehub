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

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="CVeeHub\Infrastructure\Repository\Entity\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Column(name="code", type="string", length=5)
     * @ORM\Id
     */
    private $code;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(name="phone_prefix", type="string", length=5)
     */
    private $phonePrefix;

    public function __construct(string $code, string $name, string $phonePrefix)
    {
        $this->code = $code;
        $this->name = $name;
        $this->phonePrefix = $phonePrefix;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhonePrefix(): string
    {
        return $this->phonePrefix;
    }
}
