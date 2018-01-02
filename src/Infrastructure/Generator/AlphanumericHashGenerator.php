<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Generator;

use LogicException;

/**
 * Generates cryptographically-secure alphanumeric ids.
 */
class AlphanumericHashGenerator
{
    protected const AVAILABLE_CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /** @var  int */
    private $charListMaxOffset;

    public function __construct()
    {
        $this->charListMaxOffset = strlen(static::AVAILABLE_CHARACTERS) - 1;
    }

    public function generate(int $length): string
    {
        if ($length < 1) {
            throw new LogicException('Cannot generate a hash that is shorter than one character.');
        }

        $id = '';

        for ($i = 0; $i < $length; ++$i) {
            // It's been empirically proven that shuffling this on every iteration provides better results. Seriously.
            $charList = str_shuffle(static::AVAILABLE_CHARACTERS);

            $id .= $charList[random_int(0, $this->charListMaxOffset)];
        }

        return $id;
    }
}
