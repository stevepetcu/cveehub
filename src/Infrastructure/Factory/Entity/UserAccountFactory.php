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

use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Entity\UserAccountStatus;
use CVeeHub\Domain\Model\StatusActive;
use CVeeHub\Domain\Model\StatusUnverified;
use CVeeHub\Infrastructure\Factory\Model\UserFactory;
use CVeeHub\Presentation\Request\UserAccount\CreateRequest as UserAccountCreateRequest;

class UserAccountFactory
{
    private $emailFactory;

    private $userFactory;

    private $addressFactory;

    public function __construct(
        UserFactory $userFactory,
        AddressFactory $addressFactory,
        EmailFactory $emailFactory
    ) {
        $this->emailFactory = $emailFactory;
        $this->userFactory = $userFactory;
        $this->addressFactory = $addressFactory;
    }

    public function create(UserAccountCreateRequest $request): UserAccount
    {
        $address = $this
            ->addressFactory
            ->create($request->getCountry(), $request->getPostalCode());

        $user = $this
            ->userFactory
            ->create($request->getFirstName(), $request->getLastName(), $address);

        $email = $this
            ->emailFactory
            ->create($request->getEmailAddress(), true);

        $account = new UserAccount($user, $email);

        $account->setStatus(new UserAccountStatus(new StatusActive()));
        $account->setIndustry($request->getIndustry());

        return $account;
    }
}
