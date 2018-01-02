<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Responder\Error;

use CVeeHub\Presentation\Responder\Contract\AbstractResponderPart;
use CVeeHub\Presentation\Responder\Traits\JsonResponderTrait;
use Psr\Http\Message\ResponseInterface as Response;

class ErrorResponderPart extends AbstractResponderPart
{
    use JsonResponderTrait;

    protected function getResponse(): Response
    {
        return $this->jsonResponse([
            'error' => [
                'code' => $this->response->getStatusCode(),
                'message' => $this->payload ?? $this->response->getReasonPhrase(),
            ]
        ]);
    }
}
