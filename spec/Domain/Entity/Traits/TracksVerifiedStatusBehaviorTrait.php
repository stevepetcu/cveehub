<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity\Traits;

use PhpSpec\Wrapper\Subject;

/**
 * @method void setIsVerified($isVerified)
 * @method bool|Subject isVerified()
 */
trait TracksVerifiedStatusBehaviorTrait
{
    function it_should_be_unverified_by_default()
    {
        $this->isVerified()->shouldReturn(false);
    }

    function it_can_set_and_get_is_verified()
    {
        $this->setIsVerified(true);

        $this->isVerified()->shouldReturn(true);
    }
}
