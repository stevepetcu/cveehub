<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Responder\Index;

use CVeeHub\Presentation\Representation\Builder\AppInfoRepresentationBuilder;
use CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart;

class GetResponderPart extends AbstractResourceResponderPart
{
    public function __construct(AppInfoRepresentationBuilder $representationBuilder)
    {
        $this->representationBuilder = $representationBuilder;
    }
}
