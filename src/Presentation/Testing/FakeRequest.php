<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Testing;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\Console\Exception\LogicException;

class FakeRequest implements ServerRequestInterface
{
    public $headers = [];

    public $attributes = [];

    public $parsedBody;

    /** @inheritdoc */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /** @inheritdoc */
    public function hasHeader($name)
    {
        $name = strtolower($name);

        return isset($this->normalizedHeaders()[$name]) || array_key_exists($name, $this->normalizedHeaders());
    }

    /** @inheritdoc */
    public function getHeader($name): array
    {
        $name = strtolower($name);

        return $this->normalizedHeaders()[$name] ?? [];
    }

    /** @inheritdoc */
    public function getHeaderLine($name)
    {
        return implode(',', $this->getHeader($name));
    }

    /** @inheritdoc */
    public function withHeader($name, $value)
    {
        $request = $this->withoutHeader($name);

        $request->headers[$name][] = $value;

        return $request;
    }

    /** @inheritdoc */
    public function withAddedHeader($name, $value)
    {
        $request = clone $this;

        $key = $request->findNormalizedHeaderKey($name);

        if ($key) {
            $request->headers[$key][] = $value;
        } else {
            $request->headers[$name][] = $value;
        }

        return $request;
    }

    /** @inheritdoc */
    public function withoutHeader($name)
    {
        $key = $this->findNormalizedHeaderKey($name);

        if (!$key) {
            return $this;
        }

        $request = clone $this;

        unset($request->headers[$key]);

        return $request;
    }

    /** @inheritdoc */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /** @inheritdoc */
    public function getAttribute($name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    /** @inheritdoc */
    public function withAttribute($name, $value)
    {
        $request = clone $this;

        $request->attributes[$name] = $value;

        return $request;
    }

    /** @inheritdoc */
    public function withoutAttribute($name)
    {
        $request = clone $this;

        unset($request->attributes[$name]);

        return $request;
    }

    private function normalizedHeaders()
    {
        $normalizedHeaders = [];

        foreach ($this->headers as $name => $value) {
            $normalizedHeaders[strtolower($name)] = $value;
        }

        return $normalizedHeaders;
    }

    /**
     * This is definitely not optimized.
     *
     * @param string $name The name of the header.
     *
     * @return string The key of the header, if it exists, determined in a case-insensitive fashion.
     */
    private function findNormalizedHeaderKey(string $name): ?string
    {
        if (! $this->hasHeader($name)) {
            return null;
        }

        $headerValue = $this->getHeader($name);

        return array_search($headerValue, $this->headers);
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getProtocolVersion()
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function withProtocolVersion($version)
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getBody()
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function withBody(StreamInterface $body)
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getRequestTarget()
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function withRequestTarget($requestTarget)
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getMethod()
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function withMethod($method)
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getUri()
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getServerParams(): array
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getCookieParams(): array
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function withCookieParams(array $cookies)
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getQueryParams(): array
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function withQueryParams(array $query)
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getUploadedFiles(): array
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        throw new LogicException('Not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    /**
     * @inheritdoc
     */
    public function withParsedBody($data)
    {
        $request = clone $this;

        $request->parsedBody = $data;

        return $request;
    }
}
