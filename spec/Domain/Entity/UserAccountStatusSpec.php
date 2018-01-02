<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use CVeeHub\Domain\Model\AbstractStatus;
use CVeeHub\Domain\Model\StatusActive;
use CVeeHub\Domain\Model\StatusInactive;
use CVeeHub\Domain\Model\StatusUnverified;
use PhpSpec\ObjectBehavior;

class UserAccountStatusSpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->beConstructedWith(new StatusActive());

        $this->shouldHaveType(AbstractStatus::class);
    }

    function it_has_an_id_of_2_when_it_is_active()
    {
        $this->beConstructedWith(new StatusActive());

        $this->getId()->shouldReturn(1);
        $this->getName()->shouldReturn('active');
    }

    function it_has_an_id_of_3_when_it_is_inactive()
    {
        $this->beConstructedWith(new StatusInactive());

        $this->getId()->shouldReturn(2);
        $this->getName()->shouldReturn('inactive');
    }
}
