<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Config\Exception;


class CannotReadConfigFileException extends \Exception
{
    protected $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
