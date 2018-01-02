<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Middleware\ContentNegotiation;

use CVeeHub\Presentation\ContentType\Contract\AbstractContentType;
use LogicException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class ContentNegotiationMiddleware
{
    private const ACCEPT_ANYTHING = '*/*';

    /**
     * @var AbstractContentType[]
     */
    private $contentTypes;

    public function __construct(AbstractContentType ...$contentTypes)
    {
        if (empty($contentTypes)) {
            throw new LogicException('At least one ContentType must be added to a ContentNegotiationMiddleware.');
        }

        $this->contentTypes = $contentTypes;
    }

    public function __invoke(Request $request, Response $response, callable $next): ResponseInterface
    {
        $acceptHeader = $request->getHeaderLine('Accept');

        $contentTypes = $this->negotiateContentType($acceptHeader);

        $request = $this->addPreferredContentTypes($request, $contentTypes);

        $request = $this->addAvailableContentTypes($request);

        return $next($request, $response);
    }

    private function negotiateContentType(string $acceptHeader): array
    {
        if (empty($acceptHeader) || $acceptHeader == self::ACCEPT_ANYTHING) {
            return $this->contentTypes;
        }

        $preferredContentTypes = preg_split('/\s*;\s*/', $acceptHeader)[0];
        $preferredContentTypes = preg_split('/\s*,\s*/', $preferredContentTypes);

        // Note that the order of the array_intersect arguments matters: if $this->contentTypes is first,
        // an array of ContentType objects will be returned, otherwise an array of strings will be returned.
        // Even more importantly, $preferredContentTypes is first, because we need the resulting array to keep
        // the keys of the array of preferred content types in the same order of precedence.
        return array_intersect($preferredContentTypes, $this->contentTypes);
    }

    private function addPreferredContentTypes(Request $request, array $contentTypes): Request
    {
        return $request->withAttribute(
            'PreferredContentTypes',
            $request->getAttribute('PreferredContentTypes', []) + $contentTypes
        );
    }

    private function addAvailableContentTypes(Request $request): Request
    {
        return $request->withAttribute(
            'AvailableContentTypes',
            array_merge($request->getAttribute('AvailableContentTypes', []), $this->contentTypes)
        );
    }
}
