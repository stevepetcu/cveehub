<?php

namespace spec\CVeeHub\Infrastructure\Factory\Bootstrap;

use CVeeHub\Infrastructure\Factory\Bootstrap\ConfigurationFactory;
use PhpSpec\ObjectBehavior;

class ConfigurationFactorySpec extends ObjectBehavior
{
    function let()
    {
        $configurationPaths = [
            __DIR__ . '/../../../.test_data/config/a',
            __DIR__ . '/../../../.test_data/config/b',
        ];

        $this->beConstructedWith($configurationPaths);
    }

    function it_is_instantiable()
    {
        $this->shouldBeAnInstanceOf(ConfigurationFactory::class);
    }

    function it_can_provide_a_merged_configuration_array_from_given_files()
    {
        $this->create()->shouldReturn(
            [
                'foo' => [
                    'bar' => [
                        'fuzz' => 5,
                        'buzz' => 2
                    ]
                ]
            ]
        );
    }
}
