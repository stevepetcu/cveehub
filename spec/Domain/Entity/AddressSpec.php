<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Entity\Country;
use PhpSpec\ObjectBehavior;
use spec\CVeeHub\Domain\Entity\Traits\TracksCreatedAtBehaviorTrait;

class AddressSpec extends ObjectBehavior
{
    use TracksCreatedAtBehaviorTrait;

    /**
     * Necessary for the tests coming from traits.
     */
    function let(Country $country)
    {
        $this->beConstructedWith($country, '54292');
    }

    function it_is_instantiable(Country $country)
    {
        $this->beConstructedWith($country, '54292');

        $this->shouldHaveType(Address::class);

        $this->getId()->shouldBeNull();
        $this->getCountry()->shouldReturn($country);
        $this->getPostalCode()->shouldReturn('54292');
    }
}
