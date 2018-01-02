<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Container\Definition;

use CVeeHub\Domain\Entity\Country;
use CVeeHub\Domain\Entity\Email;
use CVeeHub\Domain\Entity\Industry;
use CVeeHub\Domain\Entity\UserAccount;
use CVeeHub\Infrastructure\Repository\Entity\CountryRepository;
use CVeeHub\Infrastructure\Repository\Entity\EmailRepository;
use CVeeHub\Infrastructure\Repository\Entity\UserAccountRepository;
use CVeeHub\Infrastructure\Repository\Entity\IndustryRepository;
use DI\Definition\Source\DefinitionArray;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class RepositoryDefinition extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            UserAccountRepository::class =>
                function (ContainerInterface $container) {
                    $entityManager = $container->get(EntityManagerInterface::class);

                    return $entityManager->getRepository(UserAccount::class);
                },
            IndustryRepository::class =>
                function (ContainerInterface $container) {
                    $entityManager = $container->get(EntityManagerInterface::class);

                    return $entityManager->getRepository(Industry::class);
                },
            CountryRepository::class =>
                function (ContainerInterface $container) {
                    $entityManager = $container->get(EntityManagerInterface::class);

                    return $entityManager->getRepository(Country::class);
                },
            EmailRepository::class =>
                function (ContainerInterface $container) {
                    $entityManager = $container->get(EntityManagerInterface::class);

                    return $entityManager->getRepository(Email::class);
                },
        ];

        parent::__construct($definitions);
    }
}
