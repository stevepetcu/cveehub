<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use CVeeHub\Domain\Entity\Country;
use PhpSpec\ObjectBehavior;

class CountrySpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->beConstructedWith('DE', 'Germany', '49');

        $this->shouldHaveType(Country::class);

        $this->getCode()->shouldReturn('DE');
        $this->getName()->shouldReturn('Germany');
        $this->getPhonePrefix()->shouldReturn('49');
    }
}
