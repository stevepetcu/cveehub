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

use CVeeHub\Domain\Entity\UserAccount;

class UserAccountUrnGenerator
{
    private $hashGenerator;

    public function __construct(AlphanumericHashGenerator $hashGenerator)
    {
        $this->hashGenerator = $hashGenerator;
    }

    public function generateSimpleUrn(UserAccount $account): string
    {
        return strtolower($account->getUser()->getFirstName() . '-' . $account->getUser()->getLastName());
    }

    public function generateUniqueUrn(UserAccount $account): string
    {
        return $this->generateSimpleUrn($account) . '-' . $this->hashGenerator->generate(7);
    }
}
