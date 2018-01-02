<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Factory\Entity;

use CVeeHub\Domain\Entity\Address;
use CVeeHub\Domain\Entity\Country;

class AddressFactory
{
    public function create(Country $country, string $postalCode): Address
    {
        return new Address($country, $postalCode);
    }
}
