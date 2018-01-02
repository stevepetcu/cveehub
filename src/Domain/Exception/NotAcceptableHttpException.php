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

class NotAcceptableHttpException extends Exception implements SimplifiedExceptionInterface
{
    private const MESSAGE = 'Requested media type not available.';
    private const CODE = 406;

    public static function create(): SimplifiedExceptionInterface
    {
        return new static(self::MESSAGE, self::CODE);
    }

    public static function withPrevious(Throwable $previous): SimplifiedExceptionInterface
    {
        return new static(self::MESSAGE, self::CODE, $previous);
    }

    public static function withAvailableContentTypes(
        array $contentTypes,
        Throwable $previous = null
    ): SimplifiedExceptionInterface {
        $acceptableContentTypes = implode(', ', $contentTypes);

        return new static(
            self::MESSAGE . " Must be one of: $acceptableContentTypes.",
            self::CODE,
            $previous
        );
    }
}
