<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Exception;

use CVeeHub\Domain\Exception\Contract\SimplifiedExceptionInterface;
use Exception;
use Throwable;

class NotFoundHttpException extends Exception implements SimplifiedExceptionInterface
{
    protected const MESSAGE = "Resource not found.";
    protected const CODE = 404;

    public static function create(): SimplifiedExceptionInterface
    {
        return new static(static::MESSAGE, static::CODE);
    }

    public static function withPrevious(Throwable $previous): SimplifiedExceptionInterface
    {
        return new static(static::MESSAGE, static::CODE, $previous);
    }
}
