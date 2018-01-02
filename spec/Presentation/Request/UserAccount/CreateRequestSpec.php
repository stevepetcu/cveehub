<?php declare(strict_types=1);

namespace spec\CVeeHub\Presentation\Request\UserAccount;

use CVeeHub\Infrastructure\Testing\Traits\UserAccountCreateFakeRequestFixtureTrait;
use CVeeHub\Presentation\Request\UserAccount\CreateRequest;
use PhpSpec\ObjectBehavior;

class CreateRequestSpec extends ObjectBehavior
{
    use UserAccountCreateFakeRequestFixtureTrait;

    function let()
    {
        $request = $this->userAccountCreateFakeRequest();

        $this->beConstructedWith($request);
    }

    function it_is_instantiable()
    {
        $this->shouldHaveType(CreateRequest::class);
    }

    function it_can_get_the_first_name()
    {
        $this->getFirstName()->shouldReturn('Stefan');
    }

    function it_can_get_the_last_name()
    {
        $this->getLastName()->shouldReturn('Petcu');
    }

    function it_can_get_the_email()
    {
        $this->getEmailAddress()->shouldReturn('contact@stefanpetcu.com');
    }

    function it_can_get_the_country()
    {
        $this->getCountry()->shouldBe($this->country);
    }

    function it_can_get_the_industry()
    {
        $this->getIndustry()->shouldBe($this->industry);
    }

    function it_can_get_the_postal_code()
    {
        $this->getPostalCode()->shouldReturn('SW9 6FY');
    }
}
