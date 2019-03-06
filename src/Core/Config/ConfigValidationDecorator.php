<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Config;


use PSRG\Core\Config\Exception\IncorrectConfigValueException;
use PSRG\Core\Config\Exception\IncorrectPlayerNumberException;

class ConfigValidationDecorator implements ConfigParserInterface
{
    /**
     * @var ConfigParserInterface
     */
    protected $configReader;

    /**
     * @param ConfigParserInterface $configReader
     */
    public function __construct(ConfigParserInterface $configReader)
    {
        $this->configReader = $configReader;
    }

    /**
     * @param string $configFile
     * @return GameSettingsDTO
     * @throws IncorrectConfigValueException
     * @throws IncorrectPlayerNumberException
     */
    public function parseConfigFile(string $configFile = ''): GameSettingsDTO
    {
        $gameSettingsDTO = $this->configReader->parseConfigFile($configFile);
        $this->validateSettings($gameSettingsDTO);
        return $gameSettingsDTO;
    }

    /**
     * @param GameSettingsDTO $settings
     * @throws IncorrectConfigValueException
     * @throws IncorrectPlayerNumberException
     */
    protected function validateSettings(GameSettingsDTO $settings): void
    {
        $this->validatePlayerSettings($settings);
    }

    /**
     * @param GameSettingsDTO $settings
     * @throws IncorrectConfigValueException
     * @throws IncorrectPlayerNumberException
     */
    protected function validatePlayerSettings(GameSettingsDTO $settings): void
    {
        $this->checkIfPlayerConfigSectionHasAnValidEntry($settings);

        $this->checkPlayerSettings($settings);

        $this->checkIfPlayersHaveDupedSettings($settings);
    }

    /**
     * @param GameSettingsDTO $settings
     * @throws IncorrectConfigValueException
     */
    protected function checkIfPlayerConfigSectionHasAnValidEntry(GameSettingsDTO $settings): void
    {
        if (!is_array($settings->getPlayerSettings())) {
            throw new IncorrectConfigValueException(
                ConfigConstants::PLAYER_CONFIG_OPTION, $settings->getPlayerSettings()
            );
        }
    }

    /**
     * @param GameSettingsDTO $settings
     * @return void
     * @throws IncorrectConfigValueException
     * @throws IncorrectPlayerNumberException
     */
    protected function checkPlayerSettings(GameSettingsDTO $settings): void
    {
        $playersSettings = $settings->getPlayerSettings();

        $this->checkIfNumberOfPlayersIsCorrect($playersSettings);


        foreach ($playersSettings as $player) {

            $player = $this->checkIfPlayerNameMatchesPattern($player);

            $player = $this->checkIfPlayerTypeIsCorrect($player);

            $this->checkIfHumanDoNotHavePlayStrategyOption($player);

            $this->checkIfComputerTypeHasProperStrategyOption($player);
        }
    }

    /**
     * @param GameSettingsDTO $settings
     * @throws IncorrectConfigValueException
     */
    protected function checkIfPlayersHaveDupedSettings(GameSettingsDTO $settings): void
    {
        $playersSettings = $settings->getPlayerSettings();

        $names = [];

        foreach ($playersSettings as $playerAlias => $playerSettings) {
            $names[$playerAlias] = $playerSettings[ConfigConstants::PLAYER_NAME_KEY];
        }

        $dupes = [];
        foreach (array_count_values($names) as $val => $count) {
            if ($count > 1) $dupes[] = $val;
        }

        if (!empty($dupes)) {
            throw new IncorrectConfigValueException(ConfigConstants::PLAYER_CONFIG_OPTION, $dupes);
        }
    }

    /**
     * @param $player
     * @return mixed
     * @throws IncorrectConfigValueException
     */
    protected function checkIfPlayerNameMatchesPattern($player)
    {
        if (
            !isset($player[ConfigConstants::PLAYER_NAME_KEY])
            or !preg_match("~[\da-zA-Z_]+~", $player[ConfigConstants::PLAYER_NAME_KEY])
        ) {
            throw new IncorrectConfigValueException(
                ConfigConstants::PLAYER_CONFIG_OPTION, $player
            );
        }
        return $player;
    }

    /**
     * @param $player
     * @return mixed
     * @throws IncorrectConfigValueException
     */
    protected function checkIfPlayerTypeIsCorrect($player)
    {
        if (
            !isset($player[ConfigConstants::PLAYER_TYPE_KEY])
            or !in_array($player[ConfigConstants::PLAYER_TYPE_KEY], ConfigConstants::PLAYER_ALLOWABLE_TYPES)
        ) {
            throw new IncorrectConfigValueException(
                ConfigConstants::PLAYER_CONFIG_OPTION, $player
            );
        }
        return $player;
    }

    /**
     * @param $player
     * @throws IncorrectConfigValueException
     */
    protected function checkIfHumanDoNotHavePlayStrategyOption($player): void
    {
        if (
            $player[ConfigConstants::PLAYER_TYPE_KEY] === ConfigConstants::PLAYER_TYPE_HUMAN
            and isset($player[ConfigConstants::PLAYER_STRATEGY_KEY])
        ) {
            throw new IncorrectConfigValueException(
                ConfigConstants::PLAYER_CONFIG_OPTION, $player
            );
        }
    }

    /**
     * @param $player
     * @throws IncorrectConfigValueException
     */
    protected function checkIfComputerTypeHasProperStrategyOption($player): void
    {
        if (
            $player[ConfigConstants::PLAYER_TYPE_KEY] === ConfigConstants::PLAYER_TYPE_COMPUTER
            and !in_array($player[ConfigConstants::PLAYER_STRATEGY_KEY], ConfigConstants::PLAYER_ALLOWABLE_STRATEGIES)
        ) {
            throw new IncorrectConfigValueException(
                ConfigConstants::PLAYER_CONFIG_OPTION, $player
            );
        }
    }

    /**
     * @param $playersSettings
     * @throws IncorrectPlayerNumberException
     */
    protected function checkIfNumberOfPlayersIsCorrect($playersSettings): void
    {
        if (
            !is_array($playersSettings) or count($playersSettings) !== ConfigConstants::NUMBER_OF_PLAYERS
        ) {
            throw new IncorrectPlayerNumberException(
                count($playersSettings), ConfigConstants::NUMBER_OF_PLAYERS
            );
        }
    }
}
