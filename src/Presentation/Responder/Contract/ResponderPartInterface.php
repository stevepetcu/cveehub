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

use Psr\Http\Message\ResponseInterface as Response;

interface ResponderPartInterface
{
    public function withResponse(Response $response): ResponderInterface;

    /** @return ResponderPartInterface */
    public function withPayload($payload);

    /** @return ResponderPartInterface */
    public function withContentType(string $contentType);

    public function defaultContentType(): string;
}
