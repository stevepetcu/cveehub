<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Container\Definition;

use CVeeHub\Domain\Exception\PageNotFoundHttpException;
use CVeeHub\Presentation\Action\Error\ErrorAction;
use CVeeHub\Presentation\Action\Error\PageNotFoundAction;
use CVeeHub\Presentation\Responder\Error\ErrorResponderPart;
use DI\Definition\Source\DefinitionArray;
use Psr\Container\ContainerInterface;

class ErrorHandlerDefinition extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            'errorHandler' => function () {
                return new ErrorAction(new ErrorResponderPart());
            },
            'notFoundHandler' => function (ContainerInterface $container) {
                return new PageNotFoundAction(
                    $container->get('errorHandler'),
                    PageNotFoundHttpException::create()
                );
            }
        ];

        parent::__construct($definitions);
    }
}
