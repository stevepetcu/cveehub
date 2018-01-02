<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Action\Error;

use CVeeHub\Presentation\Action\Contract\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class PageNotFoundAction extends AbstractAction
{
    /** @var ErrorAction|callable */
    private $errorAction;

    private $exception;

    public function __construct(ErrorAction $errorAction, Throwable $exception)
    {
        $this->errorAction = $errorAction;
        $this->exception = $exception;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        return ($this->errorAction)($request, $response, $this->exception);
    }
}
