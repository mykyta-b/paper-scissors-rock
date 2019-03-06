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
