<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use CVeeHub\Domain\Entity\Country;
use CVeeHub\Domain\Entity\PhoneNumber;
use CVeeHub\Domain\Entity\UserAccount;
use PhpSpec\ObjectBehavior;
use spec\CVeeHub\Domain\Entity\Traits\TracksCreatedAtBehaviorTrait;
use spec\CVeeHub\Domain\Entity\Traits\TracksPrimaryStatusBehaviorTrait;
use spec\CVeeHub\Domain\Entity\Traits\TracksVerifiedStatusBehaviorTrait;

class PhoneNumberSpec extends ObjectBehavior
{
    use TracksCreatedAtBehaviorTrait, TracksPrimaryStatusBehaviorTrait, TracksVerifiedStatusBehaviorTrait;

    /**
     * Necessary for the tests coming from traits.
     */
    function let(UserAccount $userAccount, Country $country)
    {
        $this->beConstructedWith($userAccount, $country, '621526945', true);
    }

    function it_is_instantiable(UserAccount $userAccount, Country $country)
    {
        $this->beConstructedWith($userAccount, $country, '621526945', true);

        $this->shouldHaveType(PhoneNumber::class);

        $this->getId()->shouldBeNull();
        $this->getUserAccount()->shouldReturn($userAccount);
        $this->getCountry()->shouldReturn($country);
        $this->getNumber()->shouldReturn('621526945');
        $this->isPrimary()->shouldReturn(true);
    }

    function it_can_set_and_get_its_public_id()
    {
        $this->getPublicId()->shouldBeNull();

        $this->setPublicId('7CwZHq72YkMSKt82p');

        $this->getPublicId()->shouldReturn('7CwZHq72YkMSKt82p');
    }
}
