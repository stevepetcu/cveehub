<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Action\Error;

use CVeeHub\Presentation\Action\Contract\AbstractAction;
use CVeeHub\Presentation\Responder\Error\ErrorResponderPart;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class ErrorAction extends AbstractAction
{
    public function __construct(ErrorResponderPart $responderPart)
    {
        $this->responderPart = $responderPart;
    }

    public function __invoke(Request $request, Response $response, Throwable $throwable): Response {
        return $this
            ->errorResponder($throwable, $response)
            ->withPayload($throwable->getMessage())
            ->response();
    }
}
