<?php declare(strict_types=1);

namespace spec\CVeeHub\Domain\Entity;

use CVeeHub\Domain\Entity\Email;
use CVeeHub\Domain\Entity\Industry;
use CVeeHub\Domain\Entity\PhoneNumber;
use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Entity\UserAccountStatus;
use CVeeHub\Domain\Entity\Website;
use CVeeHub\Domain\Model\StatusActive;
use CVeeHub\Domain\Model\User;
use PhpSpec\ObjectBehavior;
use spec\CVeeHub\Domain\Entity\Traits\TracksCreatedAtBehaviorTrait;
use spec\CVeeHub\Domain\Entity\Traits\TracksUpdatedAtBehaviorTrait;

class UserAccountSpec extends ObjectBehavior
{
    use TracksCreatedAtBehaviorTrait, TracksUpdatedAtBehaviorTrait;

    private $email;

    function let(User $user)
    {
        $this->email = new Email('contact@stefanpetcu.com');

        $this->beConstructedWith($user, $this->email);
    }

    function it_is_instantiable(User $user, Email $email)
    {
        $this->beConstructedWith($user, $email);

        $this->shouldHaveType(UserAccount::class);

        $this->getId()->shouldBeNull();
        $this->getUser()->shouldReturn($user);
    }

    function it_can_set_and_get_its_status()
    {
        $status = new UserAccountStatus(new StatusActive());

        $this->setStatus($status);

        $this->getStatus()->shouldReturn($status);
    }

    function it_can_set_and_get_its_urn()
    {
        $this->setUrn('stef-petcu');

        $this->getUrn()->shouldReturn('stef-petcu');
    }

    function it_can_add_and_remove_emails(Email $email1, Email $email2)
    {
        $this->getEmails()->shouldHaveCount(1);

        $this->addEmail($email1);
        $this->addEmail($email2);

        $this->getEmails()->shouldReturn([$this->email, $email1, $email2]);

        $this->removeEmail($email1);

        $this->getEmails()->shouldHaveCount(2);
        $this->getEmails()->shouldContain($this->email);
        $this->getEmails()->shouldContain($email2);
    }

    function it_can_get_its_primary_email(Email $email1, Email $email2)
    {
        $email1->isPrimary()->willReturn(true);
        $email1->setUserAccount($this)->shouldBeCalled();

        $email2->isPrimary()->willReturn(false);
        $email2->setUserAccount($this)->shouldBeCalled();

        $this->addEmail($email1);
        $this->addEmail($email2);

        $this->getPrimaryEmail()->shouldReturn($email1);
    }

    function it_can_add_and_remove_phone_numbers(PhoneNumber $phoneNumber1, PhoneNumber $phoneNumber2)
    {
        $this->getPhoneNumbers()->shouldReturn([]);

        $this->addPhoneNumber($phoneNumber1);
        $this->addPhoneNumber($phoneNumber2);

        $this->getPhoneNumbers()->shouldReturn([$phoneNumber1, $phoneNumber2]);

        $this->removePhoneNumber($phoneNumber1);

        $this->getPhoneNumbers()->shouldHaveCount(1);
        $this->getPhoneNumbers()->shouldContain($phoneNumber2);
    }

    function it_can_get_its_primary_phone_number(PhoneNumber $phoneNumber1, PhoneNumber $phoneNumber2)
    {
        $phoneNumber1->isPrimary()->willReturn(true);
        $phoneNumber2->isPrimary()->willReturn(false);

        $this->addPhoneNumber($phoneNumber1);
        $this->addPhoneNumber($phoneNumber2);

        $this->getPrimaryPhoneNumber()->shouldReturn($phoneNumber1);
    }

    function it_can_add_and_remove_websites(Website $website1, Website $website2)
    {
        $this->getWebsites()->shouldReturn([]);

        $this->addWebsite($website1);
        $this->addWebsite($website2);

        $this->getWebsites()->shouldReturn([$website1, $website2]);

        $this->removeWebsite($website1);

        $this->getWebsites()->shouldHaveCount(1);
        $this->getWebsites()->shouldContain($website2);
    }

    function it_can_set_and_get_the_industry(Industry $industry)
    {
        $this->setIndustry($industry);

        $this->getIndustry()->shouldReturn($industry);
    }
}
