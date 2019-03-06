<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Config;

interface ConfigParserInterface
{
    public function parseConfigFile(string $configFile = ''): GameSettingsDTO;
}
