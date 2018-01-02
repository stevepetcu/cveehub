<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace spec\CVeeHub\Infrastructure\Factory\Model;

use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Entity\Country;
use CVeeHub\Domain\Model\User;
use CVeeHub\Infrastructure\Factory\Model\UserFactory;
use PhpSpec\ObjectBehavior;

class UserFactorySpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->shouldHaveType(UserFactory::class);
    }

    function it_can_create_a_user_from_a_first_and_last_name_and_an_address()
    {
        $firstName = 'Stefan';
        $lastName = 'Petcu';
        $address = new Address(
            new Country('GB', 'Great Britain', '44'),
            'SW9 6FY'
        );

        $user = $this->create($firstName, $lastName, $address);

        $user->shouldHaveType(User::class);

        $user->getFirstName()->shouldBe($firstName);
        $user->getLastName()->shouldBe($lastName);
        $user->getAddress()->shouldBe($address);
    }
}
