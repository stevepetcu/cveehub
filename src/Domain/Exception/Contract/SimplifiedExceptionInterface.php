<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Exception\Contract;

use Throwable;

/**
 * Harness the dark powers of static methods, to offer a cookie-cutter strategy
 * for easily creating exceptions with a standard $message and $code, but
 * custom $previous, while keeping the same interface for the constructor.
 */
interface SimplifiedExceptionInterface extends Throwable
{
    public static function create(): self;

    public static function withPrevious(Throwable $previous): self;
}
