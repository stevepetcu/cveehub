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

use CVeeHub\Domain\Business\Email\EmailRegistrar;
use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Infrastructure\Factory\Entity\UserAccountFactory;
use CVeeHub\Infrastructure\Generator\UserAccountUrnGenerator;
use CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository;
use CVeeHub\Presentation\Request\UserAccount\CreateRequest;

class UserAccountRegistrar
{
    private $factory;

    private $repository;

    private $urnGenerator;

    private $emailRegistrar;

    public function __construct(
        UserAccountFactory $factory,
        UserAccountUrnGenerator $urnGenerator,
        UserAccountRepository $repository,
        EmailRegistrar $emailRegistrar
    ) {
        $this->factory = $factory;
        $this->urnGenerator = $urnGenerator;
        $this->repository = $repository;
        $this->emailRegistrar = $emailRegistrar;
    }

    public function register(CreateRequest $request): UserAccount
    {
        $account = $this->factory->create($request);

        $this->setAccountUniformResourceName($account);

        $this->emailRegistrar->assignPublicId($account->getPrimaryEmail());

        // TODO: fix trying to re-persist status.
        $this->repository->save($account);

        return $account;
    }

    private function setAccountUniformResourceName(UserAccount $account): void
    {
        $account->setUrn($this->urnGenerator->generateSimpleUrn($account));

        while ($this->repository->findOneByUrn($account->getUrn())) {
            $account->setUrn($this->urnGenerator->generateUniqueUrn($account));
        }
    }
}
