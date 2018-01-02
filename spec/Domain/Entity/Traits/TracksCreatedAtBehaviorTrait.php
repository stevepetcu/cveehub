<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity\Traits;

use DateTime;
use PhpSpec\Wrapper\Subject;

/**
 * @method void setCreatedAt()
 * @method DateTime|Subject getCreatedAt()
 */
trait TracksCreatedAtBehaviorTrait
{
    function it_should_have_null_created_at_by_default()
    {
        $this->getCreatedAt()->shouldBeNull();
    }

    function it_can_set_and_get_the_created_at_date()
    {
        $now = (new DateTime())->getTimestamp();

        $this->setCreatedAt();

        /** @noinspection PhpUndefinedMethodInspection */
        $this
            ->getCreatedAt()
            ->getTimestamp()
            ->shouldBeApproximately($now, 5);
    }
}
