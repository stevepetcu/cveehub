<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Business\UserAccount;

use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Exception\Contract\SimplifiedExceptionInterface;
use CVeeHub\Domain\Exception\NotFoundHttpException;
use CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository;
use Doctrine\ORM\NoResultException;

class UserAccountFinder
{
    private $repository;

    public function __construct(UserAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $urn
     *
     * @return UserAccount
     *
     * @throws SimplifiedExceptionInterface
     */
    public function findByUrn(string $urn): UserAccount
    {
        try {
            return $this->repository->findSingleResultByUrn($urn);
        } catch (NoResultException $exception) {
            throw NotFoundHttpException::withPrevious($exception);
        }
    }
}
