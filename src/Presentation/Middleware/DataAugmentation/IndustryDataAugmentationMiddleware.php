<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Middleware\DataAugmentation;

use CVeeHub\Infrastructure\Repository\Entity\IndustryRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndustryDataAugmentationMiddleware
{
    private $repository;

    public function __construct(IndustryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request, Response $response, callable $next): ResponseInterface
    {
        $industry = $this->repository->find($request->getParsedBody()['industry_id']);

        $request = $request->withAttribute('industry', $industry);

        return $next($request, $response);
    }
}
