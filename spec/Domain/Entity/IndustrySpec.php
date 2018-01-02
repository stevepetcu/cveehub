<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use PhpSpec\ObjectBehavior;

class IndustrySpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->beConstructedWith('Internet');

        $this->getId()->shouldBeNull();
        $this->getName()->shouldReturn('Internet');
    }
}
