<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Config\Exception;


class IncorrectPlayerNumberException extends \Exception
{
    public function __construct(int $number, int $correctNumber)
    {
        $this->message = vsprintf("Incorrect number of the configured player %s, correct number is %s", [
            $number, $correctNumber
        ]);
    }
}