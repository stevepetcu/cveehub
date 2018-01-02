<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use CVeeHub\Domain\Model\AbstractWebsiteType;
use CVeeHub\Domain\Model\WebsiteTypeGitHub;
use CVeeHub\Domain\Model\WebsiteTypeLinkedIn;
use CVeeHub\Domain\Model\WebsiteTypePersonal;
use PhpSpec\ObjectBehavior;

class WebsiteTypeSpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->beConstructedWith(new WebsiteTypePersonal());

        $this->shouldHaveType(AbstractWebsiteType::class);
    }

    function it_has_an_id_of_1_when_it_is_personal()
    {
        $this->beConstructedWith(new WebsiteTypePersonal());

        $this->getId()->shouldReturn(1);
        $this->getName()->shouldReturn('personal');
    }

    function it_has_an_id_of_2_when_it_is_github()
    {
        $this->beConstructedWith(new WebsiteTypeGitHub());

        $this->getId()->shouldReturn(2);
        $this->getName()->shouldReturn('github');
    }

    function it_has_an_id_of_3_when_it_is_linkedin()
    {
        $this->beConstructedWith(new WebsiteTypeLinkedIn());

        $this->getId()->shouldReturn(3);
        $this->getName()->shouldReturn('linkedin');
    }
}
