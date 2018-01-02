<?php declare(strict_types=1);

namespace spec\CVeeHub\Infrastructure\Generator;

use CVeeHub\Infrastructure\Generator\AlphanumericHashGenerator;
use CVeeHub\Infrastructure\Generator\UserAccountUrnGenerator;
use CVeeHub\Infrastructure\Testing\Traits\UserAccountFixtureTrait;
use PhpSpec\ObjectBehavior;

class UserAccountUrnGeneratorSpec extends ObjectBehavior
{
    use UserAccountFixtureTrait;

    function let()
    {
        $hashGenerator = new AlphanumericHashGenerator();

        $this->beConstructedWith($hashGenerator);
    }

    function it_is_instantiable()
    {
        $this->shouldHaveType(UserAccountUrnGenerator::class);
    }

    function it_can_generate_a_user_account_urn_from_first_and_last_name()
    {
        $this->generateSimpleUrn($this->userAccount())->shouldBe('stefan-petcu');
    }

    function it_can_generate_a_unique_user_account_urn()
    {
        $this->generateUniqueUrn($this->userAccount())->shouldMatch('/stefan-petcu-[a-zA-Z0-9]{7}/');
    }
}
