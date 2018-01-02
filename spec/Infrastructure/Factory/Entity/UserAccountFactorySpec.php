<?php declare(strict_types=1);

namespace spec\CVeeHub\Infrastructure\Factory\Entity;

use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Infrastructure\Factory\Entity\UserAccountFactory;
use CVeeHub\Infrastructure\Factory\Entity\AddressFactory;
use CVeeHub\Infrastructure\Factory\Entity\EmailFactory;
use CVeeHub\Infrastructure\Factory\Model\UserFactory;
use CVeeHub\Infrastructure\Testing\Traits\UserAccountCreateFakeRequestFixtureTrait;
use CVeeHub\Presentation\Request\UserAccount\CreateRequest;
use PhpSpec\ObjectBehavior;

class UserAccountFactorySpec extends ObjectBehavior
{
    use UserAccountCreateFakeRequestFixtureTrait;

    function let()
    {
        $userFactory = new UserFactory();
        $addressFactory = new AddressFactory();
        $emailFactory = new EmailFactory();

        $this->beConstructedWith($userFactory, $addressFactory, $emailFactory);
    }

    function it_is_instantiable()
    {
        $this->shouldHaveType(UserAccountFactory::class);
    }

    function it_can_create_a_user_account_from_a_user_account_create_request()
    {
        $request = new CreateRequest($this->userAccountCreateFakeRequest());

        $userAccount = $this->create($request);

        $userAccount->shouldHaveType(UserAccount::class);

        $user = $userAccount->getUser();
        $address = $userAccount->getUser()->getAddress();
        $emails = $userAccount->getEmails();

        $user->getFirstName()->shouldBe('Stefan');
        $user->getLastName()->shouldBe('Petcu');

        $address->getCountry()->getCode()->shouldBe('GB');
        $address->getCountry()->getName()->shouldBe('Great Britain');
        $address->getCountry()->getPhonePrefix()->shouldBe('44');

        $emails->shouldBeArray();
        $emails->shouldHaveCount(1);
        $emails[0]->getEmail()->shouldBe('contact@stefanpetcu.com');
    }
}
