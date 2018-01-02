<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Model;

use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Model\User;
use DateTime;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function let(Address $address)
    {
        $this->beConstructedWith('Stefan', 'Petcu', $address);
    }

    function it_is_instantiable()
    {
        $this->shouldHaveType(User::class);
    }

    function it_can_set_and_get_its_first_name()
    {
        $this->getFirstName()->shouldReturn('Stefan');

        $this->setFirstName('Stefan-Daniel');

        $this->getFirstName()->shouldReturn('Stefan-Daniel');
    }

    function it_can_set_and_get_its_last_name()
    {
        $this->getLastName()->shouldReturn('Petcu');

        $this->setLastName('Test');

        $this->getLastName()->shouldReturn('Test');
    }

    function it_can_set_and_get_its_date_of_birth()
    {
        $this->getDateOfBirth()->shouldReturn(null);

        $now = (new DateTime())->getTimestamp();

        $this->setDateOfBirth(new DateTime());

        $this->getDateOfBirth()->getTimestamp()->shouldBeApproximately($now, 5);
    }

    function it_can_set_and_get_its_address(Address $address)
    {
        $this->getAddress()->shouldHaveType(Address::class);

        $this->setAddress($address);

        $this->getAddress()->shouldReturn($address);
    }

    function it_can_unset_its_date_of_birth()
    {
        $this->setDateOfBirth(null);

        $this->getDateOfBirth()->shouldBeNull();
    }
}
