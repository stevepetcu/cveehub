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
use Throwable;

interface ResponderInterface extends ResponderPartInterface
{
    public function response(): Response;

    public function withError(Throwable $throwable): ResponderInterface;

    /** @return ResponderInterface */
    public function withPayload($payload);

    /** @return ResponderInterface */
    public function withContentType(string $contentType);
}
