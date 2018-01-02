<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\Responder\UserAccount;

use CVeeHub\Presentation\Representation\Builder\EmptyRepresentationBuilder;
use CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart;

class PostResponderPart extends AbstractResourceResponderPart
{
    public function __construct(EmptyRepresentationBuilder $representationBuilder)
    {
        $this->representationBuilder = $representationBuilder;
    }
}
