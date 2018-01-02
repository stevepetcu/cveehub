<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Entity\Website;
use CVeeHub\Domain\Entity\WebsiteType;
use CVeeHub\Domain\Model\WebsiteTypeGitHub;
use CVeeHub\Domain\Model\WebsiteTypePersonal;
use PhpSpec\ObjectBehavior;
use spec\CVeeHub\Domain\Entity\Traits\TracksCreatedAtBehaviorTrait;
use spec\CVeeHub\Domain\Entity\Traits\TracksUpdatedAtBehaviorTrait;

class WebsiteSpec extends ObjectBehavior
{
    use TracksCreatedAtBehaviorTrait, TracksUpdatedAtBehaviorTrait;

    /**
     * Necessary for the tests coming from traits.
     */
    function let(UserAccount $userAccount)
    {
        $this->beConstructedWith(
            $userAccount,
            new WebsiteType(new WebsiteTypePersonal()),
            'https://www.stefanpetcu.com'
            );
    }

    function it_is_instantiable(UserAccount $userAccount)
    {
        $this->beConstructedWith(
            $userAccount,
            new WebsiteType(new WebsiteTypePersonal()),
            'https://www.stefanpetcu.com'
        );

        $this->shouldHaveType(Website::class);

        $this->getId()->shouldBeNull();
        $this->getUserAccount()->shouldReturn($userAccount);
        $this->getUrl()->shouldReturn('https://www.stefanpetcu.com');
        $this->getType()->shouldHaveType(WebsiteType::class);
    }

    function it_can_set_and_get_the_url()
    {
        $this->setUrl('https://www.cveehub.com');

        $this->getUrl()->shouldReturn('https://www.cveehub.com');
    }

    function it_can_set_and_get_the_type()
    {
        $this->setType(new WebsiteType(new WebsiteTypeGitHub()));

        $this->getType()->getName()->shouldReturn('github');
    }

    function it_can_set_and_get_its_public_id()
    {
        $this->getPublicId()->shouldBeNull();

        $this->setPublicId('7CwZHq72YkMSKt82p');

        $this->getPublicId()->shouldReturn('7CwZHq72YkMSKt82p');
    }
}
