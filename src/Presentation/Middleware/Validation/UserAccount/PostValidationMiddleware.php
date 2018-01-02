<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Middleware\Validation\UserAccount;

use CVeeHub\Infrastructure\Repository\Entity\EmailRepository;
use CVeeHub\Infrastructure\Validator\Request\UserAccount\PostValidator;
use CVeeHub\Presentation\Request\UserAccount\CreateRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostValidationMiddleware
{
    private $emailRepository;

    private $validator;

    public function __construct(EmailRepository $emailRepository, PostValidator $validator)
    {
        $this->emailRepository = $emailRepository;
        $this->validator = $validator;
    }

    public function __invoke(Request $request, Response $response, callable $next): ResponseInterface
    {
        $requestBody = $request->getParsedBody();

        $validationResult = $this->validator->validate($requestBody);

        if (!$validationResult->passed()) {
            // TODO: create an exception here.
            print_r($validationResult->errors());
            die;
        }

        if ($this->emailRepository->findByEmail($requestBody['email'])) {
            throw new \Exception('Email already exists!'); // TODO: create new domain level exception, or change workflow with this errors.
            // TODO: throwing an exception here funcked up. No catch! Fix!
        }

        $request = $request->withAttribute(
            'create_request',
            new CreateRequest($request) // TODO: inject a request factory
        );

        return $next($request, $response);
    }
}
