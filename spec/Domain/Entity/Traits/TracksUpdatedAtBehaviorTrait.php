<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity\Traits;

use DateTime;
use PhpSpec\Wrapper\Subject;

/**
 * @method void setUpdatedAt()
 * @method DateTime|Subject getUpdatedAt()
 */
trait TracksUpdatedAtBehaviorTrait
{
    function it_should_have_null_updated_at_by_default()
    {
        $this->getUpdatedAt()->shouldBeNull();
    }

    function it_can_set_and_get_the_updated_at_date()
    {
        $now = (new DateTime())->getTimestamp();

        $this->setUpdatedAt();

        /** @noinspection PhpUndefinedMethodInspection */
        $this
            ->getUpdatedAt()
            ->getTimestamp()
            ->shouldBeApproximately($now, 5);
    }
}
