<?php declare(strict_types=1);

namespace spec\CVeeHub\Presentation\ContentType;

use CVeeHub\Presentation\ContentType\ContentTypeTextXml;
use PhpSpec\ObjectBehavior;

class ContentTypeTextXmlSpec extends ObjectBehavior
{
    function it_evaluates_to_text_json_when_cast_to_a_string()
    {
        $this->shouldHaveType(ContentTypeTextXml::class);

        $this->__toString()->shouldReturn('text/xml');
    }
}
