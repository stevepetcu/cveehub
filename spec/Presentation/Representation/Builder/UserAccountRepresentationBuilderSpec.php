<?php declare(strict_types=1);

namespace spec\CVeeHub\Presentation\Representation\Builder;

use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Entity\Country;
use CVeeHub\Domain\Entity\PhoneNumber;
use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Domain\Entity\Website;
use CVeeHub\Domain\Entity\WebsiteType;
use CVeeHub\Domain\Model\WebsiteTypePersonal;
use CVeeHub\Infrastructure\Testing\Traits\UserAccountFixtureTrait;
use CVeeHub\Presentation\Representation\Builder\UserAccountRepresentationBuilder;
use DateTime;
use PhpSpec\ObjectBehavior;
use TypeError;

class UserAccountRepresentationBuilderSpec extends ObjectBehavior
{
    use UserAccountFixtureTrait;

    function it_is_instantiable()
    {
        $this->shouldHaveType(UserAccountRepresentationBuilder::class);
    }

    function it_can_build_a_partial_json_representation()
    {
        $userAccount = $this->bootstrapBaseUserAccount();

        $this
            ->setResource($userAccount)
            ->jsonRepresentation()
            ->shouldReturn($this->expectedBaseUserAccountJsonRepresentation());
    }

    function it_can_build_the_full_json_representation()
    {
        $userAccount = $this->bootstrapFullUserAccount(
            $this->bootstrapBaseUserAccount()
        );

        $jsonRepresentation = $this->setResource($userAccount)->jsonRepresentation();

        $jsonRepresentation
            ->shouldReturn(
                $this
                    ->expectedFullUserAccountJsonRepresentation(
                        $userAccount->getCreatedAt(),
                        $userAccount->getUpdatedAt()
                    )
            );
    }

    private function bootstrapBaseUserAccount(): UserAccount
    {
        $userAccount = $this->userAccount();

        return $userAccount;
    }

    private function bootstrapFullUserAccount(UserAccount $baseAccount): UserAccount
    {
        $phoneNumber = new PhoneNumber(
            $baseAccount,
            new Country('LU', 'Luxembourg', '352'),
            '621526945',
            true
        );
        $phoneNumber->setPublicId('wSE4lwXeYesHavi8F');

        $baseAccount->addPhoneNumber($phoneNumber);

        $website = new Website(
            $baseAccount,
            new WebsiteType(new WebsiteTypePersonal()),
            'https://www.stefanpetcu.com'
        );
        $website->setPublicId('Vg5qgaeC0lYaEhqpH');

        $baseAccount->addWebsite($website);

        $baseAccount->getUser()->setAddress(
            new Address(
                new Country('DE', 'Germany', '49'),
                '54292'
            )
        );

        $baseAccount
            ->getUser()
            ->setDateOfBirth(
                new DateTime('1992-03-23')
            );

        $baseAccount->setCreatedAt();

        // Sleep 2 seconds, otherwise the createdAt == updatedAt, leading to possibly overlooking some problems.
        sleep(2);

        $baseAccount->setUpdatedAt();

        return $baseAccount;
    }

    private function expectedBaseUserAccountJsonRepresentation(): array
    {
        return [
            'first_name' => 'Stefan',
            'last_name' => 'Petcu',
            'industry' => 'Internet',
            'urn' => 'stefan-petcu',
            'status' => 'active',
            'date_of_birth' => null,
            'emails' => [
                [
                    'id' => 'MDlU9OZtaXmFZ024z',
                    'email' => 'contact@stefanpetcu.com',
                    'primary' => true,
                    'verified' => false
                ]
            ],
            'phone_numbers' => [],
            'websites' => [],
            'address' => [
                'country' => [
                    'name' => 'United Kingdom',
                    'code' => 'UK',
                    'phone_prefix' => '44',
                ],
                'postal_code' => 'SW9 6FY'
            ],
            'created_at' => null,
            'updated_at' => null
        ];
    }

    private function expectedFullUserAccountJsonRepresentation(DateTime $createdAt, DateTime $updatedAt): array
    {
        return [
            'first_name' => 'Stefan',
            'last_name' => 'Petcu',
            'industry' => 'Internet',
            'urn' => 'stefan-petcu',
            'status' => 'active',
            'date_of_birth' => '1992-03-23',
            'emails' => [
                [
                    'id' => 'MDlU9OZtaXmFZ024z',
                    'email' => 'contact@stefanpetcu.com',
                    'primary' => true,
                    'verified' => false
                ]
            ],
            'phone_numbers' => [
                [
                    'id' => 'wSE4lwXeYesHavi8F',
                    'number' => '621526945',
                    'country' => [
                        'name' => 'Luxembourg',
                        'code' => 'LU',
                        'phone_prefix' => '352',
                    ],
                    'primary' => true,
                    'verified' => false
                ]
            ],
            'websites' => [
                [
                    'id' => 'Vg5qgaeC0lYaEhqpH',
                    'url' => 'https://www.stefanpetcu.com',
                    'type' => 'personal'
                ]
            ],
            'address' => [
                'country' => [
                    'name' => 'Germany',
                    'code' => 'DE',
                    'phone_prefix' => '49'
                ],
                'postal_code' => '54292'
            ],
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $updatedAt->format('Y-m-d H:i:s')
        ];
    }

    function it_only_accepts_resources_of_type_user_account()
    {
        $this
            ->shouldThrow(new TypeError('Resource should be of type ' . UserAccount::class . '.'))
            ->during('setResource', ['userAccount' => 'NotAppInfo']);
    }
}
