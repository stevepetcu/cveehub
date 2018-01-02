<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Model;

use CVeeHub\Domain\Model\AppInfo;
use PhpSpec\ObjectBehavior;

class AppInfoSpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->beConstructedWith('app name', 'app version', 'code source url');

        $this->shouldHaveType(AppInfo::class);

        $this->getName()->shouldReturn('app name');
        $this->getVersion()->shouldReturn('app version');
        $this->getSource()->shouldReturn('code source url');
    }
}
