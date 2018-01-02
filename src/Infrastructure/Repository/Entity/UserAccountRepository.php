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

use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Infrastructure\Repository\Contract\AbstractEntityRepository;
use Doctrine\ORM\NoResultException;

class UserAccountRepository extends AbstractEntityRepository
{
    public function findOneByUrn(string $urn): ?UserAccount
    {
        /** @var UserAccount|null $userAccount */
        $userAccount = $this->findOneBy(compact('urn'));

        return $userAccount;
    }

    /**
     * @param string $urn
     *
     * @return UserAccount
     *
     * @throws NoResultException
     */
    public function findSingleResultByUrn(string $urn): UserAccount
    {
        $userAccount = $this->findOneByUrn($urn);

        if (null === $userAccount) {
            throw new NoResultException();
        }

        return $userAccount;
    }
}
