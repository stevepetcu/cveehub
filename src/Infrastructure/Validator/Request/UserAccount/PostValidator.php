<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Validator\Request\UserAccount;

use CVeeHub\Infrastructure\Validator\Contract\AbstractValidator;

class PostValidator extends AbstractValidator
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'country_code' => 'required|alpha|max_len,3|min_len,2',
            'postal_code' => 'required|alpha_space|max_len,10|min_len,2',
            'email' => 'required|valid_email',
            'industry_id' => 'required|numeric',
        ];
    }

    protected function customMessages(): array
    {
        return [
            'industry_id' => 'Invalid industry id.'
        ];
    }
}
