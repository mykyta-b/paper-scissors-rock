<?php

include dirname(__FILE__). '/../../../vendor/autoload.php';

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

use PSRG\UI\InputReader;

$inputReader = new InputReader();

echo $inputReader->readInput();
