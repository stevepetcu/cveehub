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
use Slim\Http\Body;

/**
 * @mixin AbstractResponderPart
 */
trait XmlResponderTrait
{
    protected function xmlResponse(string $xml): ResponseInterface
    {
        $response = $this->response->withBody(
            new Body(fopen('php://temp', 'r+'))
        );

        $response->getBody()->write($xml);

        return $response->withHeader('Content-Type', 'text/xml;charset=utf-8');
    }
}
