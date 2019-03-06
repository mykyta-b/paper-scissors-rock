<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class InputReaderTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $pathToInput = __DIR__ . DIRECTORY_SEPARATOR . 'inputReader.php';
        $res = `echo "Y" | php $pathToInput`;

        $this->assertEquals("Y", $res);
    }
}
