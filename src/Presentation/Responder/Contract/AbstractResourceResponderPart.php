<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Responder\Contract;

use CVeeHub\Presentation\Representation\Builder\Contract\RepresentationBuilderInterface;
use CVeeHub\Presentation\Responder\Traits\JsonResponderTrait;
use CVeeHub\Presentation\Responder\Traits\XmlResponderTrait;
use LogicException;
use Psr\Http\Message\ResponseInterface as Response;

abstract class AbstractResourceResponderPart extends AbstractResponderPart
{
    use JsonResponderTrait, XmlResponderTrait;

    private const BAD_RESPONSE_METHOD_ERROR_MESSAGE = "Class '%s' does not implement method '%s'.";

    /** @var  RepresentationBuilderInterface */
    protected $representationBuilder;

    /**
     * Checks if a response can be built with the specified content type for
     * the current resource and, if yes, returns that response.
     *
     * @param string $contentType
     *
     * @return Response
     *
     * @throws LogicException
     */
    public function __call(string $representationType, array $arguments): Response
    {
        $responseMethod = $representationType . 'Response';

        if (!method_exists($this, $responseMethod)) {
            throw new LogicException(
                sprintf(
                    self::BAD_RESPONSE_METHOD_ERROR_MESSAGE,
                    static::class,
                    $responseMethod
                )
            );
        }

        return $this->$responseMethod($arguments[0]);
    }

    protected function getResponse(): Response
    {
        $representation = $this->representation();

        return $this->{$this->representationType()}($representation);
    }

    protected function representation()
    {
        if (empty($this->representationBuilder)) {
            throw new LogicException(
                'The representation builder of ' . static::class . ' cannot be empty. Add one in the constructor.'
            );
        }

        $this->representationBuilder->setResource($this->payload);

        return $this->representationBuilder->{$this->representationType()}();
    }

    private function representationType(): string
    {
        $contentType = $this->contentType ?? $this->defaultContentType();

        return explode('/', $contentType)[1];
    }
}
