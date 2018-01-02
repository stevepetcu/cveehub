<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Factory\Model;

use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Model\User;

class UserFactory
{
    public function create(string $firstName, string $lastName, Address $address): User
    {
        return new User($firstName, $lastName, $address);
    }
}
