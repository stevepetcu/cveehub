<?php declare(strict_types=1);

namespace spec\CVeeHub\Infrastructure\Factory\Entity;

use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Entity\Country;
use CVeeHub\Infrastructure\Factory\Entity\AddressFactory;
use PhpSpec\ObjectBehavior;

class AddressFactorySpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->shouldHaveType(AddressFactory::class);
    }

    function it_can_create_an_address_from_a_country_and_a_postal_code()
    {
        $country = new Country('GB', 'Great Britain', '44');
        $postalCode = 'SW9 6FY';

        $address = $this->create($country, $postalCode);

        $address->shouldHaveType(Address::class);

        $address->getCountry()->shouldBe($country);
        $address->getPostalCode()->shouldBe($postalCode);
    }
}
