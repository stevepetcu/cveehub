<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity\Traits;

use PhpSpec\Wrapper\Subject;

/**
 * @method void setIsPrimary($isPrimary)
 * @method bool|Subject isPrimary()
 */
trait TracksPrimaryStatusBehaviorTrait
{
    function it_can_set_and_get_is_primary()
    {
        $this->setIsPrimary(false);

        $this->isPrimary()->shouldReturn(false);
    }
}
