<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Presentation\ContentType;

use CVeeHub\Presentation\ContentType\Contract\AbstractContentType;

class ContentTypeTextXml extends AbstractContentType
{
    public function __construct()
    {
        $this->type = 'text/xml';
    }
}
