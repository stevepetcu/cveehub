<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Repository\Entity;

use CVeeHub\Domain\Entity\Country;
use CVeeHub\Infrastructure\Repository\Contract\AbstractEntityRepository;

class CountryRepository extends AbstractEntityRepository
{
    public function findByCode(string $code): ?Country
    {
        /** @var Country|null $country */
        $country = $this->findOneBy(compact('code'));

        return $country;
    }
}
