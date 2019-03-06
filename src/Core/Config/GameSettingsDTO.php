<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Config;


class GameSettingsDTO
{

    /**
     * @var array
     */
    protected $playerSettings;

    /**
     * @var array
     */
    protected $statSettings;

    /**
     * @return array
     */
    public function getStatSettings(): array
    {
        return $this->statSettings;
    }

    /**
     * @param array $statSettings
     * @return GameSettingsDTO
     */
    public function setStatSettings(array $statSettings): GameSettingsDTO
    {
        $this->statSettings = $statSettings;
        return $this;
    }

    /**
     * @return array
     */
    public function getPlayerSettings(): array
    {
        return $this->playerSettings;
    }

    /**
     * @param array $playerSettings
     * @return GameSettingsDTO
     */
    public function setPlayerSettings(array $playerSettings): GameSettingsDTO
    {
        $this->playerSettings = $playerSettings;
        return $this;
    }
}
