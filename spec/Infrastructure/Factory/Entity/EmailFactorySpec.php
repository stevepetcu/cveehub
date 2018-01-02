<?php declare(strict_types=1);

namespace spec\CVeeHub\Infrastructure\Factory\Entity;

use CVeeHub\Domain\Entity\Email;
use CVeeHub\Infrastructure\Factory\Entity\EmailFactory;
use PhpSpec\ObjectBehavior;

class EmailFactorySpec extends ObjectBehavior
{
    function it_is_instantiable()
    {
        $this->shouldHaveType(EmailFactory::class);
    }

    function it_can_create_an_email_from_a_string()
    {
        $email = $this->create('contact@stefanpetcu.com');

        $email->shouldHaveType(Email::class);

        $email->getId()->shouldBeNull();
        $email->getPublicId()->shouldBeNull();
        $email->getUserAccount()->shouldBeNull();
        $email->isPrimary()->shouldBe(false);
        $email->getEmail()->shouldReturn('contact@stefanpetcu.com');
    }

    function it_can_create_a_primary_email()
    {
        $email = $this->create('contact@stefanpetcu.com', true);

        $email->shouldHaveType(Email::class);

        $email->isPrimary()->shouldBe(true);
    }
}
