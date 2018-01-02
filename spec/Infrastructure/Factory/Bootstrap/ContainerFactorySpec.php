<?php

namespace spec\CVeeHub\Infrastructure\Factory\Bootstrap;

use CVeeHub\Infrastructure\Factory\Bootstrap\ContainerFactory;
use CVeeHub\Infrastructure\Provider\ApplicationProvider;
use DI\Cache\ArrayCache;
use DI\Definition\Source\DefinitionArray;
use PhpSpec\ObjectBehavior;
use Psr\Container\ContainerInterface;

class ContainerFactorySpec extends ObjectBehavior
{
    function let(ApplicationProvider $provider)
    {
        $configuration = [
            //cache required by ContainerFactory (a cache should always be present)
            'application.container.cache_class' => ArrayCache::class,
            'test_config_value' => 5,
        ];

        $testProvider = new class extends DefinitionArray
        {
            public function __construct()
            {
                $definitions = [
                    'TestProvidedValue' => function (ContainerInterface $container) {
                        return $container->get('test_config_value') . 'test-value';
                    }
                ];

                parent::__construct($definitions);
            }
        };

        $provider->getDefinitions()->willReturn([new $testProvider]);

        $this->beConstructedWith($configuration, [$provider]);
    }

    function it_is_instantiable()
    {
        $this->shouldBeAnInstanceOf(ContainerFactory::class);
    }

    function it_can_provide_a_container_with_configuration_and_providers()
    {
        $container = $this->create();

        $container->shouldBeAnInstanceOf(ContainerInterface::class);
        $container->get('test_config_value')->shouldReturn(5);
        $container->get('TestProvidedValue')->shouldReturn('5test-value');
    }
}
