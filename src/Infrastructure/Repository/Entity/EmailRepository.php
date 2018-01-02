<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Repository\Entity;

use CVeeHub\Domain\Entity\Email;
use CVeeHub\Infrastructure\Repository\Contract\AbstractEntityRepository;

class EmailRepository extends AbstractEntityRepository
{
    public function findByPublicId(string $publicId): ?Email
    {
        /** @var Email|null $email */
        $email = $this->findOneBy(compact('publicId'));

        return $email;
    }

    public function findByEmail(string $email): ?Email
    {
        /** @var Email|null $email */
        $email = $this->findOneBy(compact('email'));

        return $email;
    }
}
