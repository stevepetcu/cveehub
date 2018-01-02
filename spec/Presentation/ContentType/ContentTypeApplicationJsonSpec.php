<?php declare(strict_types=1);

namespace spec\CVeeHub\Presentation\ContentType;

use CVeeHub\Presentation\ContentType\ContentTypeApplicationJson;
use PhpSpec\ObjectBehavior;

class ContentTypeApplicationJsonSpec extends ObjectBehavior
{
    function it_evaluates_to_application_json_when_cast_to_a_string()
    {
        $this->shouldHaveType(ContentTypeApplicationJson::class);

        $this->__toString()->shouldReturn('application/json');
    }
}
