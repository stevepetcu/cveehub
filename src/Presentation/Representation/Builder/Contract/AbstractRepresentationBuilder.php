<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Representation\Builder\Contract;

use LogicException;

abstract class AbstractRepresentationBuilder implements RepresentationBuilderInterface
{
    private const BAD_REPRESENTATION_TYPE_ERROR_MESSAGE = "Class '%s' does not implement method '%s'.";

    /**
     * Checks if the representation of the resource can be built with
     * the right format and, if yes, returns that representation.
     *
     * @return mixed
     *
     * @throws LogicException
     */
    public function __call(string $representationType, array $arguments)
    {
        $buildMethod = $representationType . 'Representation';

        if (!method_exists($this, $buildMethod)) {
            throw new LogicException(
                sprintf(
                    self::BAD_REPRESENTATION_TYPE_ERROR_MESSAGE,
                    static::class,
                    $buildMethod
                )
            );
        }

        return $this->$buildMethod();
    }
}
