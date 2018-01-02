<?php declare(strict_types=1);

namespace spec\CVeeHub\Infrastructure\Generator;

use CVeeHub\Infrastructure\Generator\AlphanumericHashGenerator;
use CVeeHub\Infrastructure\Generator\EntityPublicIdGenerator;
use PhpSpec\ObjectBehavior;

class EntityPublicIdGeneratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new AlphanumericHashGenerator(), 17);
    }

    function it_is_instantiable()
    {
        $this->shouldHaveType(EntityPublicIdGenerator::class);
    }

    function it_generates_alphanumeric_hashes_of_17_characters()
    {
        $this->generate()->shouldMatch('/[a-zA-Z0-9]{17}/');
    }
}
