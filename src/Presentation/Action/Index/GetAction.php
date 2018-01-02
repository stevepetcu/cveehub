<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Action\Index;

use CVeeHub\Domain\Business\Application\AppInfoFinder;
use CVeeHub\Presentation\Action\Contract\AbstractAction;
use CVeeHub\Presentation\Responder\Index\GetResponderPart;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetAction extends AbstractAction
{
    private $finder;

    public function __construct(GetResponderPart $responderPart, AppInfoFinder $finder)
    {
        $this->responderPart = $responderPart;
        $this->finder = $finder;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        return $this
            ->responder($request, $response)
            ->withPayload($this->finder->findAppInfo())
            ->response();
    }
}
