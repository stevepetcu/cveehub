<?php declare(strict_types=1);

namespace spec\CVeeHub\Infrastructure\Generator;

use CVeeHub\Infrastructure\Generator\AlphanumericHashGenerator;
use LogicException;
use PhpSpec\ObjectBehavior;

class AlphanumericHashGeneratorSpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->shouldHaveType(AlphanumericHashGenerator::class);
    }

    function it_throws_exception_if_requested_hash_length_is_below_one()
    {
        $this
            ->shouldThrow(new LogicException('Cannot generate a hash that is shorter than one character.'))
            ->during('generate', [0]);

        $this
            ->shouldThrow(new LogicException('Cannot generate a hash that is shorter than one character.'))
            ->during('generate', [-10]);
    }

    function it_can_generate_alphanumeric_hashes_of_given_length()
    {
        for ($length = 1; $length < 4097; $length *= 8) {
            $this->generate($length)->shouldMatch("/[a-zA-Z0-9]{{$length}}/");
        }
    }
}
