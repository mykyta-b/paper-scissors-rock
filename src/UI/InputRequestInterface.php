<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\UI;

interface InputRequestInterface
{
    public function requestInput(string $inputTip, array $possibleOptions): string;
}
