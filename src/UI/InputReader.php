<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\UI;


class InputReader
{

    public function readInput()
    {
        $stdin = fopen('php://stdin', 'r');
        $userInput = trim(fgets($stdin));
        fclose($stdin);
        return $userInput;
    }
}
