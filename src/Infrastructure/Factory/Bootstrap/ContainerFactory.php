<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Factory\Bootstrap;

use CVeeHub\Infrastructure\Factory\Contract\SimpleFactoryInterface;
use CVeeHub\Infrastructure\Provider\Contract\ProviderInterface;
use DI\Container;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class ContainerFactory implements SimpleFactoryInterface
{
    /** @var array */
    private $configuration;

    /** @var ProviderInterface[] */
    private $providers;

    /** @var ContainerBuilder */
    private $builder;

    public function __construct(array $configuration, array $providers = [])
    {
        $this->configuration = $configuration;
        $this->providers = $providers;

        $containerClass = $this->configuration['application.container.class'] ?? Container::class;

        $this->builder = new ContainerBuilder($containerClass);
    }

    public function create(): ContainerInterface
    {
        $this->addDefaultDefinitions();

        $this->addConfigurationDefinitions();

        $this->addProviderDefinitions();

        $this->addCache();

        return $this->builder->build();
    }

    /**
     * Add default definitions, provided by the PHP-DI\Slim-Bridge package.
     */
    private function addDefaultDefinitions()
    {
        $this->builder->addDefinitions(PATH_ROOT . '/vendor/php-di/slim-bridge/src/config.php');
    }

    /**
     * Add definitions provided in the application's configuration files.
     */
    private function addConfigurationDefinitions()
    {
        $this->builder->addDefinitions($this->configuration);
    }

    /**
     * Add definitions provided by the application's providers.
     */
    private function addProviderDefinitions()
    {
        foreach ($this->providers as $provider) {
            foreach ($provider->getDefinitions() as $definition) {
                $this->builder->addDefinitions($definition);
            }
        }
    }

    private function addCache()
    {
        $this->builder->setDefinitionCache(new $this->configuration['application.container.cache_class']);
    }
}
