<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Factory\Entity;

use CVeeHub\Domain\Entity\Email;

class EmailFactory
{
    public function create(string $emailAddress, bool $isPrimary = false): Email
    {
        return new Email($emailAddress, $isPrimary);
    }
}
