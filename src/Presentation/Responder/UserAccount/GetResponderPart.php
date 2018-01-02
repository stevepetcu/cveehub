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

use CVeeHub\Presentation\Representation\Builder\UserAccountRepresentationBuilder;
use CVeeHub\Presentation\Responder\Contract\AbstractResourceResponderPart;

class GetResponderPart extends AbstractResourceResponderPart
{
    public function __construct(UserAccountRepresentationBuilder $representationBuilder)
    {
        $this->representationBuilder = $representationBuilder;
    }
}
