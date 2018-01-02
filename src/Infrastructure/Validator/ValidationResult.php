<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Validator;

class ValidationResult
{
    private $passed;

    private $errors;

    public function __construct(bool $passed, array $errors)
    {
        $this->passed = $passed;
        $this->errors = $errors;
    }

    public function passed(): bool
    {
        return $this->passed;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
