<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Action\UserAccount;

use CVeeHub\Domain\Business\UserAccount\UserAccountRegistrar;
use CVeeHub\Presentation\Action\Contract\AbstractAction;
use CVeeHub\Presentation\Responder\UserAccount\PostResponderPart;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostAction extends AbstractAction
{
    private $registrar;

    public function __construct(PostResponderPart $responderPart, UserAccountRegistrar $registrar)
    {
        $this->responderPart = $responderPart;
        $this->registrar = $registrar;
    }

    public function __invoke(Request $request, Response $response)
    {
        $createRequest = $request->getAttribute('create_request');

        $userAccount = $this->registrar->register($createRequest);

        $response = $response
            ->withStatus(201, 'Created')
            ->withHeader('Location', "/{$userAccount->getUrn()}");

        print_r($response);
        die;

        return $this
            ->responder($request, $response)
            ->response();
    }
}
