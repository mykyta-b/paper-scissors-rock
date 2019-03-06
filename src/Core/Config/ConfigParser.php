<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Config;


use PSRG\Core\Config\Exception\CannotReadConfigFileException;

class ConfigParser implements ConfigParserInterface
{
    const CAN_NOT_READ_GIVEN_CONFIGURATION_FILE = "Configuration file %s does not exist";
    const CAN_NOT_FIND_REQUIRED_SECTION = "Can not find required section %s in %s";

    public function parseConfigFile(string $configFile = ''): GameSettingsDTO
    {
        $configContent = $this->readConfig($configFile);
        return $this->parseConfigContent($configFile, $configContent);
    }

    /**
     * @param string $configFile
     * @return array|bool
     * @throws CannotReadConfigFileException
     */
    protected function readConfig(string $configFile)
    {
        if (!file_exists($configFile)) {
            throw new CannotReadConfigFileException(sprintf(self::CAN_NOT_READ_GIVEN_CONFIGURATION_FILE, $configFile));
        }

        return  parse_ini_file($configFile, true);
    }

    /**
     * @param string $configFile
     * @param $configContent
     * @return GameSettingsDTO
     * @throws CannotReadConfigFileException
     */
    protected function parseConfigContent(string $configFile, $configContent): GameSettingsDTO
    {
        if (!isset($configContent[ConfigConstants::PLAYER_CONFIG_OPTION])) {
            throw new CannotReadConfigFileException(sprintf(self::CAN_NOT_FIND_REQUIRED_SECTION, [ConfigConstants::PLAYER_CONFIG_OPTION, $configFile]));
        }

        return (new GameSettingsDTO())
            ->setPlayerSettings($configContent[ConfigConstants::PLAYER_CONFIG_OPTION])
            ->setStatSettings($configContent[ConfigConstants::STATS_CONFIG_OPTION])
            ;
    }

}
