<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Repository\Contract;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;

abstract class AbstractEntityRepository extends EntityRepository
{
    /**
     * Makes object managed and persisted. Flushes all changes to the given
     * object (and possible cascades), to the database.
     *
     * @param object $entity The instance to make managed and persistent.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     */
    public function save($entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
