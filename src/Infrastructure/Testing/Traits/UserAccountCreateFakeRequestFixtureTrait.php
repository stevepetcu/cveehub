<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Testing\Traits;

use CVeeHub\Domain\Entity\Country;
use CVeeHub\Domain\Entity\Industry;
use CVeeHub\Presentation\Testing\FakeRequest;

trait UserAccountCreateFakeRequestFixtureTrait
{
    private $country;

    private $industry;

    protected function userAccountCreateFakeRequest(): FakeRequest
    {
        $request = (new FakeRequest())->withParsedBody(
            [
                'first_name' => 'Stefan',
                'last_name' => 'Petcu',
                'email' => 'contact@stefanpetcu.com',
                'country_code' => 'GB',
                'postal_code' => 'SW9 6FY',
                'industry_id' => 1
            ]
        );

        $this->country = new Country(
            'GB',
            'Great Britain',
            '44'
        );

        $request = $request->withAttribute(
            'country',
            $this->country
        );

        $this->industry = new Industry('Internet');

        $request = $request->withAttribute(
            'industry',
            $this->industry
        );

        return $request;
    }
}
