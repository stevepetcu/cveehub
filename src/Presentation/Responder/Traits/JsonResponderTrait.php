<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Responder\Traits;

use CVeeHub\Presentation\Responder\Contract\AbstractResponderPart;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Slim\Http\Body;

/**
 * @mixin AbstractResponderPart
 */
trait JsonResponderTrait
{
    /**
     * @param mixed $data
     * @param int $encodingOptions Json encoding options. Right now, it is impossible to use these.
     *                             If needed in the future, the ResponderPartInterface could include a
     *                             withOptions() method.
     *
     * @return ResponseInterface
     */
    protected function jsonResponse($data, $encodingOptions = 0): ResponseInterface
    {
        // If there's no data, encode an empty JSON object.
        $data = $data ?? "{}";

        $json = json_encode($data, $encodingOptions);

        if (false === $json) {
            throw new RuntimeException(json_last_error_msg(), json_last_error());
        }

        $response = $this->response->withBody(
            new Body(fopen('php://temp', 'r+'))
        );

        $response->getBody()->write($json);

        return $response->withHeader('Content-Type', 'application/json;charset=utf-8');
    }
}
