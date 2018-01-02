<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Testing\Traits;

use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Entity\Country;
use CVeeHub\Domain\Entity\Email;
use CVeeHub\Domain\Entity\Industry;
use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Entity\UserAccountStatus;
use CVeeHub\Domain\Model\StatusActive;
use CVeeHub\Domain\Model\User;

trait UserAccountFixtureTrait
{
    protected function userAccount(): UserAccount
    {
        $address = new Address(
            new Country('UK', 'United Kingdom', '44'),
            'SW9 6FY'
        );

        $user = new User('Stefan', 'Petcu', $address);

        $email = new Email('contact@stefanpetcu.com', true);
        $email->setPublicId('MDlU9OZtaXmFZ024z');

        $userAccount = new UserAccount($user, $email);

        $userAccount->setIndustry(new Industry('Internet'));
        $userAccount->setUrn('stefan-petcu');
        $userAccount->setStatus(new UserAccountStatus(new StatusActive()));

        return $userAccount;
    }
}
