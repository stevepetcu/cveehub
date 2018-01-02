<?php declare(strict_types=1);

namespace spec\CVeeHub\Presentation\Testing;

use CVeeHub\Presentation\Testing\FakeRequest;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ServerRequestInterface;

class FakeRequestSpec extends ObjectBehavior
{
    function let()
    {
        $this->headers = ['foo' => ['bar', 'car'], 'Fizz' => null];
        $this->attributes = ['fuzz' => 'buzz'];
    }

    function it_is_instantiable()
    {
        $this->shouldHaveType(FakeRequest::class);
        $this->shouldHaveType(ServerRequestInterface::class);
    }

    function it_can_get_its_headers()
    {
        $this->getHeaders()->shouldReturn(['foo' => ['bar', 'car'], 'Fizz' => null]);
    }

    function it_can_check_the_existence_of_a_header_by_its_name_in_a_case_insensitive_manner()
    {
        $this->hasHeader('foo')->shouldReturn(true);
        $this->hasHeader('FoO')->shouldReturn(true);
        $this->hasHeader('fizz')->shouldReturn(true);

        $this->hasHeader('bar')->shouldReturn(false);
        $this->hasHeader('Baz')->shouldReturn(false);
    }

    function it_can_get_a_header_by_its_name_in_a_case_insensitive_manner()
    {
        $this->getHeader('Foo')->shouldReturn(['bar', 'car']);
    }

    function it_can_get_a_header_line_by_its_name_in_a_case_insensitive_manner()
    {
        $this->getHeaderLine('Foo')->shouldReturn('bar,car');
        $this->getHeaderLine('Fizz')->shouldReturn('');
        $this->getHeaderLine('Fuzz')->shouldReturn('');
    }

    function it_can_add_or_replace_a_header_in_a_case_insensitive_manner_while_maintaining_immutability()
    {
        $request = $this->withHeader('Foo', 'Fizz');
        $request->headers->shouldBe(['Fizz' => null, 'Foo' => ['Fizz']]);

        $this->headers->shouldBe(['foo' => ['bar', 'car'], 'Fizz' => null]);
    }

    function it_can_add_to_a_header_in_a_case_insensitive_manner_while_maintaining_immutability()
    {
        $request = $this->withAddedHeader('Foo', 'Fizz');
        $request->headers->shouldBe(['foo' => ['bar', 'car', 'Fizz'], 'Fizz' => null]);

        $request = $this->withAddedHeader('Car', 'Caz');
        $request->headers->shouldBe(['foo' => ['bar', 'car'], 'Fizz' => null, 'Car' => ['Caz']]);

        $this->headers->shouldBe(['foo' => ['bar', 'car'], 'Fizz' => null]);
    }

    function it_can_remove_a_header_in_a_case_insensitive_manner_while_maintaining_immutability()
    {
        $request = $this->withoutHeader('Foo');
        $request->headers->shouldBe(['Fizz' => null]);

        $this->headers->shouldBe(['foo' => ['bar', 'car'], 'Fizz' => null]);

        $this->withoutHeader('Fuzz')->shouldReturn($this);
    }

    function it_can_get_its_attributes()
    {
        $this->getAttributes()->shouldReturn(['fuzz' => 'buzz']);
    }

    function it_can_get_an_attribute_by_name_with_default_fallback()
    {
        $this->getAttribute('fuzz')->shouldReturn('buzz');
        $this->getAttribute('Fuzz', 'Not there.')->shouldReturn('Not there.');
    }

    function it_can_add_or_replace_an_attribute_while_maintaining_immutability()
    {
        $request = $this->withAttribute('fuzz', 'not-buzz')->withAttribute('Fuzz', 'Buzz');

        $request->getAttributes()->shouldReturn(['fuzz' => 'not-buzz', 'Fuzz' => 'Buzz']);

        $this->getAttributes()->shouldReturn(['fuzz' => 'buzz']);
    }

    function it_can_remove_an_attribute_while_maintaining_immutability()
    {
        $request = $this->withoutAttribute('fuzz');

        $request->getAttributes()->shouldReturn([]);

        $this->getAttributes()->shouldReturn(['fuzz' => 'buzz']);
    }
}
