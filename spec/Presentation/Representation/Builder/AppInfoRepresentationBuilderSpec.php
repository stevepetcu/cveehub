<?php declare(strict_types=1);

namespace spec\CVeeHub\Presentation\Representation\Builder;

use CVeeHub\Domain\Model\AppInfo;
use CVeeHub\Presentation\Representation\Builder\AppInfoRepresentationBuilder;
use LogicException;
use PhpSpec\ObjectBehavior;
use TypeError;

class AppInfoRepresentationBuilderSpec extends ObjectBehavior
{
    /** @var  AppInfo */
    private $appInfo;

    function let()
    {
        $this->appInfo = new AppInfo('test-name', 'test-ver', 'test-src');
    }

    function it_is_instantiable()
    {
        $this->shouldHaveType(AppInfoRepresentationBuilder::class);
    }

    function it_can_build_the_json_representation()
    {
        $this
            ->setResource($this->appInfo)
            ->jsonRepresentation()
            ->shouldReturn(
                [
                    'name' => 'test-name',
                    'version' => 'test-ver',
                    'source' => 'test-src',
                ]
            );
    }

    function it_can_build_the_xml_representation()
    {
        $expectedXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<application>
  <name>test-name</name>
  <version>test-ver</version>
  <source>test-src</source>
</application>
XML;

        $this
            ->setResource($this->appInfo)
            ->xmlRepresentation()
            ->shouldReturn($expectedXml);
    }

    function it_only_accepts_resources_of_type_app_info()
    {
        $this
            ->shouldThrow(new TypeError('Resource should be of type ' . AppInfo::class . '.'))
            ->during('setResource', ['appInfo' => 'NotAppInfo']);
    }

    function it_can_call_representation_building_methods_based_on_the_representation_type()
    {
        $this
            ->setResource($this->appInfo)
            ->json()
            ->shouldReturn(
                [
                    'name' => 'test-name',
                    'version' => 'test-ver',
                    'source' => 'test-src',
                ]
            );
    }

    function it_throws_logic_exception_when_trying_to_call_inexistent_method()
    {
        $this->shouldThrow(
            new LogicException(
                "Class 'CVeeHub\Presentation\Representation\Builder\AppInfoRepresentationBuilder'"
                . " does not implement method 'htmlRepresentation'."
            )
        )
            ->during('__call', ['representationType' => 'html', 'arguments' => []]);
    }
}
