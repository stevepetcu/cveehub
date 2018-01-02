<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use CVeeHub\Domain\Entity\Email;
use PhpSpec\ObjectBehavior;
use spec\CVeeHub\Domain\Entity\Traits\TracksCreatedAtBehaviorTrait;
use spec\CVeeHub\Domain\Entity\Traits\TracksPrimaryStatusBehaviorTrait;
use spec\CVeeHub\Domain\Entity\Traits\TracksVerifiedStatusBehaviorTrait;

class EmailSpec extends ObjectBehavior
{
    use TracksCreatedAtBehaviorTrait, TracksPrimaryStatusBehaviorTrait, TracksVerifiedStatusBehaviorTrait;

    /**
     * Necessary for the tests coming from traits.
     */
    function let()
    {
        $this->beConstructedWith('stefan.petcu@cveehub.com', true);
    }

    function it_is_instantiable()
    {
        $this->beConstructedWith('stefan.petcu@cveehub.com', true);

        $this->shouldHaveType(Email::class);

        $this->getId()->shouldBeNull();
        $this->getEmail()->shouldReturn('stefan.petcu@cveehub.com');
        $this->isPrimary()->shouldReturn(true);
    }

    function it_can_set_and_get_its_public_id()
    {
        $this->getPublicId()->shouldBeNull();

        $this->setPublicId('7CwZHq72YkMSKt82p');

        $this->getPublicId()->shouldReturn('7CwZHq72YkMSKt82p');
    }
}
