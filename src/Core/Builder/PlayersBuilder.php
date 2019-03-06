<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\Builder;


use PSRG\Core\Config\ConfigConstants;
use PSRG\Core\Config\GameSettingsDTO;
use PSRG\Core\DTO\PlayerDTO;

class PlayersBuilder
{
    /**
     * @param GameSettingsDTO $gameSettingsDTO
     * @return PlayerDTO[]
     */
    public function createPlayers(GameSettingsDTO $gameSettingsDTO): array
    {
        $players = [];

        foreach ($gameSettingsDTO->getPlayerSettings() as $playerAlias => $playerSettings) {
            $playerDTO = (new PlayerDTO())
                ->setAlias($playerAlias)
                ->setName($playerSettings[ConfigConstants::PLAYER_NAME_KEY])

                ->setType($playerSettings[ConfigConstants::PLAYER_TYPE_KEY]);

            if (isset($playerSettings[ConfigConstants::PLAYER_STRATEGY_KEY])) {
                $playerDTO->setStrategy($playerSettings[ConfigConstants::PLAYER_STRATEGY_KEY]);
            }

            $players[] = $playerDTO;

        }

        return $players;
    }
}
