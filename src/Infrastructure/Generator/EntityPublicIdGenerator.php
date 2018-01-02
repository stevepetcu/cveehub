<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Generator;

/**
 * This class can generate 739632519584070 unique alphanumeric combinations with a $publicIdLength of 17.
 */
class EntityPublicIdGenerator
{
    /** @var AlphanumericHashGenerator */
    protected $hashGenerator;

    /** @var int */
    protected $publicIdLength;

    public function __construct(AlphanumericHashGenerator $hashGenerator, int $publicIdLength)
    {
        $this->hashGenerator = $hashGenerator;
        $this->publicIdLength = $publicIdLength;
    }

    /** @inheritdoc */
    public function generate(): string
    {
        return $this->hashGenerator->generate($this->publicIdLength);
    }
}
