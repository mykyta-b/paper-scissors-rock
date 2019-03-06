<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Config\Exception;


class IncorrectConfigValueException extends \Exception
{
    protected $message;

    public function __construct(string $fieldName, $fieldValue)
    {
        $value = $fieldValue;
        if (is_array($fieldValue)) {
            $value = print_r($fieldValue, 1);
        }

        $this->message = vsprintf("Incorrect value %s for config option %s", [
            $fieldName,
            $value
        ]);
    }
}
