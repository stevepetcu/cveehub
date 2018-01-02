<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Representation\Builder;

use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Presentation\Representation\Builder\Contract\AbstractRepresentationBuilder;
use CVeeHub\Presentation\Representation\Builder\Contract\JsonRepresentationBuilderInterface;
use TypeError;

class UserAccountRepresentationBuilder extends AbstractRepresentationBuilder implements
    JsonRepresentationBuilderInterface
{
    /** @var  UserAccount */
    private $userAccount;

    public function setResource($userAccount): self
    {
        if (!$userAccount instanceof UserAccount) {
            throw new TypeError('Resource should be of type ' . UserAccount::class . '.');
        }

        $this->userAccount = $userAccount;

        return $this;
    }

    public function jsonRepresentation(): array
    {
        $user = $this->userAccount->getUser();
        $industry = $this->userAccount->getIndustry();

        [
            'dateOfBirth' => $dateOfBirth,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt
        ] = $this->getFormattedDates();

        $userAccountData = [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'industry' => $industry->getName(),
            'urn' => $this->userAccount->getUrn(),
            'status' => $this->userAccount->getStatus()->getName(),
            'date_of_birth' => $dateOfBirth,
            'emails' => $this->getFormattedEmailsData(),
            'phone_numbers' => $this->getFormattedPhoneNumbersData(),
            'websites' => $this->getFormattedWebsitesData(),
            'address' => $this->getFormattedAddressData(),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt
        ];

        return $userAccountData;
    }

    private function getFormattedDates(): array
    {
        $user = $this->userAccount->getUser();

        $dateOfBirth = $user->getDateOfBirth()
            ? $user->getDateOfBirth()->format('Y-m-d')
            : null;

        $createdAt = $this->userAccount->getCreatedAt()
            ? $this->userAccount->getCreatedAt()->format('Y-m-d H:i:s')
            : null;

        $updatedAt = $this->userAccount->getUpdatedAt()
            ? $this->userAccount->getUpdatedAt()->format('Y-m-d H:i:s')
            : null;

        return compact('dateOfBirth', 'createdAt', 'updatedAt');
    }

    private function getFormattedEmailsData(): array
    {
        $emails = $this->userAccount->getEmails();

        $data = [];

        foreach ($emails as $email) {
            $data[] = [
                'id' => $email->getPublicId(),
                'email' => $email->getEmail(),
                'primary' => $email->isPrimary(),
                'verified' => $email->isVerified()
            ];
        }

        return $data;
    }

    private function getFormattedPhoneNumbersData(): array
    {
        $phoneNumbers = $this->userAccount->getPhoneNumbers();

        $data = [];

        foreach ($phoneNumbers as $phoneNumber) {
            $country = $phoneNumber->getCountry();

            $data[] = [
                'id' => $phoneNumber->getPublicId(),
                'number' => $phoneNumber->getNumber(),
                'country' => [
                    'name' => $country->getName(),
                    'code' => $country->getCode(),
                    'phone_prefix' => $country->getPhonePrefix()
                ],
                'primary' => $phoneNumber->isPrimary(),
                'verified' => $phoneNumber->isVerified()
            ];
        }

        return $data;
    }

    private function getFormattedWebsitesData(): array
    {
        $websites = $this->userAccount->getWebsites();

        $data = [];

        foreach ($websites as $website) {
            $data[] = [
                'id' => $website->getPublicId(),
                'url' => $website->getUrl(),
                'type' => $website->getType()->getName()
            ];
        }

        return $data;
    }

    private function getFormattedAddressData(): ?array
    {
        $address = $this->userAccount->getUser()->getAddress();

        if (!$address) {
            return null;
        }

        $country = $address->getCountry();

        return [
            'country' => [
                'name' => $country->getName(),
                'code' => $country->getCode(),
                'phone_prefix' => $country->getPhonePrefix()
            ],
            'postal_code' => $address->getPostalCode()
        ];
    }
}
