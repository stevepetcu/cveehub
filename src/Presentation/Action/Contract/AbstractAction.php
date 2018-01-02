<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Action\Contract;

use CVeeHub\Domain\Exception\NotAcceptableHttpException;
use CVeeHub\Presentation\Responder\Contract\AbstractResponderPart;
use CVeeHub\Presentation\Responder\Contract\ResponderInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

abstract class AbstractAction
{
    /** @var  AbstractResponderPart */
    protected $responderPart;

    protected function responder(Request $request, Response $response): ResponderInterface
    {
        return $this
            ->responderPart
            ->withResponse($response)
            ->withContentType(
                $this->decideResponseContentType($request)
            );
    }

    protected function errorResponder(Throwable $throwable, Response $response): ResponderInterface
    {
        return $this
            ->responderPart
            ->withResponse($response)
            ->withError($throwable);
    }

    /**
     * Returns the best available content type from the list of requested content types.
     *
     * @param Request $request
     *
     * @return string
     *
     * @throws NotAcceptableHttpException
     */
    protected function decideResponseContentType(Request $request): string
    {
        $contentTypes = $request->getAttribute('PreferredContentTypes', null);

        if ([] === $contentTypes) {
            // The content type negotiation could not reach a satisfactory result.
            throw NotAcceptableHttpException::withAvailableContentTypes(
                $request->getAttribute('AvailableContentTypes', null)
                ?? [$this->responderPart->defaultContentType()]
            );
        }

        if (null === $contentTypes) {
            // This action does not negotiate content types.
            return $this->responderPart->defaultContentType();
        }

        ksort($contentTypes);

        return (string) current($contentTypes);
    }
}
