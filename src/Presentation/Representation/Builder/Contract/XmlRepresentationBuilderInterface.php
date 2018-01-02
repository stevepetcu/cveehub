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

interface XmlRepresentationBuilderInterface extends RepresentationBuilderInterface
{
    public function xmlRepresentation(): string;
}
