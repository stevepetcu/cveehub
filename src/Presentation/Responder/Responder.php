<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Responder;

use CVeeHub\Presentation\Responder\Contract\AbstractResponderPart;
use CVeeHub\Presentation\Responder\Contract\ResponderInterface;
use CVeeHub\Presentation\Responder\Error\ErrorResponderPart;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class Responder extends AbstractResponderPart implements ResponderInterface
{
    private $responderPart;

    public function __construct(
        AbstractResponderPart $responder,
        Response $response
    ) {
        $this->responderPart = $responder;
        $this->response = $response;
    }

    public function withResponse(Response $response): ResponderInterface
    {
        return $this->responderPart->withResponse($response);
    }

    public function withPayload($payload): ResponderInterface
    {
        $this->responderPart->withPayload($payload);

        return $this;
    }

    public function withContentType(string $contentType): ResponderInterface
    {
        $this->responderPart->withContentType($contentType);

        return $this;
    }

    public function withError(Throwable $throwable): ResponderInterface
    {
        $responderPart = $this->responderPart instanceof ErrorResponderPart
            ? $this->responderPart
            : new ErrorResponderPart();

        return $responderPart->withResponse(
            $this->response->withStatus(
                $throwable->getCode(),
                $throwable->getMessage()
            )
        );
    }

    public function response(): Response
    {
        return $this->getResponse();
    }

    protected function getResponse(): Response
    {
        return $this->responderPart->getResponse();
    }
}
