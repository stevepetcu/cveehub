<?php declare(strict_types=1);

namespace spec\CVeeHub\Presentation\ContentType;

use CVeeHub\Presentation\ContentType\ContentTypeApplicationXml;
use PhpSpec\ObjectBehavior;

class ContentTypeApplicationXmlSpec extends ObjectBehavior
{
    function it_evaluates_to_text_json_when_cast_to_a_string()
    {
        $this->shouldHaveType(ContentTypeApplicationXml::class);

        $this->__toString()->shouldReturn('application/xml');
    }
}
