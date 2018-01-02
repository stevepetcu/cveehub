<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Validator\Contract;

use CVeeHub\Infrastructure\Validator\ValidationResult;
use GUMP;

abstract class AbstractValidator
{
    private $validator;

    public function __construct(GUMP $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validates $data and returns a ValidationResult.
     * Suggested errors array format:
     * [
     *      'fieldName' => [
     *          'errorMessage_1',
     *          'errorMessage_2'
     *      ],
     * ]
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function validate($data): ValidationResult
    {
        $errors = [];

        $result = $this->validator->validate($data, $this->rules());

        if (true !== $result) {
            $errors = $this->composeErrorMessages($result);
        }

        $validationPassed = empty($errors) ? true : false;

        return new ValidationResult($validationPassed, $errors);
    }

    /**
     * Returns the array of rules that the validator applies.
     * The format of this array should be:
     * [
     *      'fieldName' => '<rules>',
     * ]
     *
     * @return array
     */
    abstract protected function rules(): array;

    private function composeErrorMessages(array $errors): array
    {
        $messages = $this->messages();
        $errorMessages = [];

        foreach ($errors as $errorInfo) {
            $errorMessages[$errorInfo['field']][$errorInfo['rule']] = sprintf($messages[$errorInfo['rule']], $errorInfo['field']);
        }

        return $errorMessages;
    }

    protected function customMessages(): array
    {
        return [];
    }

    private function defaultMessages(): array
    {
        return [
            'validate_required' => 'The %s is a required field.',
            'validate_max_len' => 'The %s cannot be longer than xxx characters.',
            'validate_min_len' => 'The %s cannot be shorter than xxx characters.',
            'validate_alpha' => 'The %s may only contain alphabet characters.',
            'validate_alpha_numeric' => 'The %s may only contain alphanumeric characters.',
            'validate_numeric' => 'The %s may only contain numeric characters.',
            'validate_valid_email' => 'The %s must be a valid email address.',
        ];
    }

    private function messages(): array
    {
        return $this->customMessages() + $this->defaultMessages();
    }
}
