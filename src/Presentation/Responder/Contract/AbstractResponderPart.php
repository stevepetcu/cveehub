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

use CVeeHub\Presentation\ContentType\ContentTypeApplicationJson;
use CVeeHub\Presentation\Responder\Responder;
use Psr\Http\Message\ResponseInterface as Response;

abstract class AbstractResponderPart implements ResponderPartInterface
{
    /** @var  mixed */
    protected $payload;

    /** @var  string */
    protected $contentType;

    /** @var  Response */
    protected $response;

    public function withResponse(Response $response): ResponderInterface
    {
        $this->response = $response;

        return (new Responder($this, $response));
    }

    public function withPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    public function withContentType(string $contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function defaultContentType(): string
    {
        return (string) new ContentTypeApplicationJson();
    }

    abstract protected function getResponse(): Response;
}
