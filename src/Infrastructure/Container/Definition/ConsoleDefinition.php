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

use DI\Definition\Source\DefinitionArray;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Provides the DI Container with the definition for the CLI Application.
 *
 * We add Doctrine's Console Runner commands to our CLI Application, so
 * a definition for that is also provided in the form of a HelperSet.
 */
class ConsoleDefinition extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            Application::class => function (ContainerInterface $container) {
                $application = new Application(
                    $container->get('application.name'),
                    $container->get('application.version')
                );

                $application->setHelperSet($container->get('doctrine.console.helperset'));

                ConsoleRunner::addCommands($application);

                return $application;
            },
            'doctrine.console.helperset' => function (ContainerInterface $container) {
                $entityManager = $container->get(EntityManagerInterface::class);

                return new HelperSet(array(
                    'db' => new ConnectionHelper($entityManager->getConnection()),
                    'em' => new EntityManagerHelper($entityManager)
                ));
            },
        ];

        parent::__construct($definitions);
    }
}
