<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Request\UserAccount;

use CVeeHub\Domain\Entity\Country;
use CVeeHub\Domain\Entity\Industry;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateRequest
{
    private $firstName;

    private $lastName;

    private $emailAddress;

    private $country;

    private $postalCode;

    private $industry;

    public function __construct(Request $request)
    {
        $requestBody = $request->getParsedBody();

        $this->firstName = $requestBody['first_name'];
        $this->lastName = $requestBody['last_name'];
        $this->emailAddress = $requestBody['email'];
        $this->postalCode = $requestBody['postal_code'];

        $this->country = $request->getAttribute('country');
        $this->industry = $request->getAttribute('industry');
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getIndustry(): Industry
    {
        return $this->industry;
    }
}
